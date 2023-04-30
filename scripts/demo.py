#!/usr/bin/python
# -*- coding: utf-8 -*-
import json
import numpy as np
import os
import cv2 as cv
from time import time
from PIL import Image
from collections import OrderedDict
import gc

import torch
import torch.nn as nn
from hlmobilenetv2 import hlmobilenetv2

# ignore warnings
import warnings

warnings.filterwarnings("ignore")

#print("Start : demo")

IMG_SCALE = 1. / 255
IMG_MEAN = np.array([0.485, 0.456, 0.406, 0]).reshape((1, 1, 4))
IMG_STD = np.array([0.229, 0.224, 0.225, 1]).reshape((1, 1, 4))

STRIDE = 32
RESTORE_FROM = '/var/www/html/scripts/pretrained/indexnet_matting.pth.tar'
RESULT_DIR = '/var/www/html/scripts/examples/mattes'

device = torch.device("cuda:0" if torch.cuda.is_available() else "cpu")

#print("After : device")

if not os.path.exists(RESULT_DIR):
    os.makedirs(RESULT_DIR)

# load pretrained model
net = hlmobilenetv2(
    pretrained=False,
    freeze_bn=True,
    output_stride=STRIDE,
    apply_aspp=True,
    conv_operator='std_conv',
    decoder='indexnet',
    decoder_kernel_size=5,
    indexnet='depthwise',
    index_mode='m2o',
    use_nonlinear=True,
    use_context=True
)

try:
    checkpoint = torch.load(RESTORE_FROM, map_location=device)
    pretrained_dict = OrderedDict()
    for key, value in checkpoint['state_dict'].items():
        with torch.no_grad():
            if 'module' in key:
                key = key[7:]
            pretrained_dict[key] = value
except:
    raise Exception('Please download the pretrained model!')
    print('Please download the pretrained model!')
    
net.load_state_dict(pretrained_dict)
net.to(device)
if torch.cuda.is_available():
    net = nn.DataParallel(net)
    
# switch to eval mode
net.eval()

#print("After : net.eval()")

def read_image(x):
    img_arr = np.array(Image.open(x), dtype=np.float32)
    return img_arr


def image_alignment(x, output_stride, odd=False):
    imsize = np.asarray(x.shape[:2], dtype=np.float32)
    if odd:
        new_imsize = np.ceil(imsize / output_stride) * output_stride + 1
    else:
        new_imsize = np.ceil(imsize / output_stride) * output_stride
    h, w = int(new_imsize[0]), int(new_imsize[1])

    x1 = x[:, :, 0:3]
    x2 = x[:, :, 3]
    new_x1 = cv.resize(x1, dsize=(w, h), interpolation=cv.INTER_CUBIC)
    new_x2 = cv.resize(x2, dsize=(w, h), interpolation=cv.INTER_NEAREST)

    new_x2 = np.expand_dims(new_x2, axis=2)
    new_x = np.concatenate((new_x1, new_x2), axis=2)

    return new_x


def inference(image_path, trimap_path):
    with torch.no_grad():
        image, trimap = read_image(image_path), read_image(trimap_path)
        trimap = np.expand_dims(trimap, axis=2)
        image = np.concatenate((image, trimap), axis=2)

        h, w = image.shape[:2]

        image = image.astype('float32')
        image = (IMG_SCALE * image - IMG_MEAN) / IMG_STD
        image = image.astype('float32')

        image = image_alignment(image, STRIDE)
        inputs = torch.from_numpy(np.expand_dims(image.transpose(2, 0, 1), axis=0))
        inputs = inputs.to(device)

        gc.collect()

        # inference
        try:
            start = time()
            outputs = net(inputs)
            end = time()
            print('OK')
        except Exception as e:
            print(e)

        outputs = outputs.squeeze().cpu().numpy()
        alpha = cv.resize(outputs, dsize=(w, h), interpolation=cv.INTER_CUBIC)
        alpha = np.clip(alpha, 0, 1) * 255.
        trimap = trimap.squeeze()
        mask = np.equal(trimap, 128).astype(np.float32)
        alpha = (1 - mask) * trimap + mask * alpha

        _, image_name = os.path.split(image_path)
        Image.fromarray(alpha.astype(np.uint8)).save(os.path.join(RESULT_DIR, image_name))
        # Image.fromarray(alpha.astype(np.uint8)).show()

#        print("Done_demo")

with open('/var/www/html/getFunction.json') as f:
    df = json.load(f)
    
#image_path = ['/var/www/html/scripts/examples/images/hamabe.png']
#trimap_path = ['/var/www/html/scripts/examples/trimaps/hamabe.png']
image_path = ['/var/www/html/scripts/examples/images/'+df['img_name']]
trimap_path = ['/var/www/html/scripts/examples/trimaps/'+df['img_name']]

#print("Start : for")
for image, trimap in zip(image_path, trimap_path):
    inference(image, trimap)
#print("End : for")