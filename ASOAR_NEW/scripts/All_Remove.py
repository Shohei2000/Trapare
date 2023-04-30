import gc

import numpy as np
import cv2 as cv
import matplotlib
matplotlib.use("agg")
import matplotlib.pyplot as plt
# "agg" is a non-GUI backend, so you will need to save to a file. – Klaifer Garcia -

import torchvision
from torchvision import transforms

import os
from time import time
from PIL import Image
from collections import OrderedDict

import torch
import torch.nn as nn
from hlmobilenetv2 import hlmobilenetv2

# ignore warnings
import warnings

import ssl
ssl._create_default_https_context = ssl._create_unverified_context
# ↑実行するためのおまじない
# model = torchvision.models.segmentation.deeplabv3_resnet101(pretrained=True)

import random

image_name = 'hamabe.png'
img = cv.imread('./examples/images/'+image_name, -1)
img = img[...,::-1] #BGR->RGB
h,w,_ = img.shape
img = cv.resize(img,(320,320))

device = torch.device("cuda:0" if torch.cuda.is_available() else "cpu")

# model = torch.hub.load('pytorch/vision:v0.9.0', 'deeplabv3_resnet101', pretrained=True)
model = torchvision.models.segmentation.deeplabv3_resnet101(pretrained=True)
model = model.to(device)
model.eval();


preprocess = transforms.Compose([
    transforms.ToTensor(),
    transforms.Normalize(mean=[0.485, 0.456, 0.406], std=[0.229, 0.224, 0.225]),
])

input_tensor = preprocess(img)
input_batch = input_tensor.unsqueeze(0).to(device)


with torch.no_grad():
    output = model(input_batch)['out'][0]
#output = torch.stack([output[0],output[15]])  #0:background,15:person
output = output.argmax(0)

mask = output.byte().cpu().numpy()
mask = cv.resize(mask,(w,h))
img = cv.resize(img,(w,h))
plt.gray()
plt.figure(figsize=(20,20))
plt.subplot(1,2,1)
#plt.imshow(img)
plt.subplot(1,2,2)
#plt.imshow(mask);

def gen_trimap(mask,k_size=(5,5),ite=5):
    kernel = np.ones(k_size,np.uint8)
    eroded = cv.erode(mask,kernel,iterations = ite)# 膨張処理
    dilated = cv.dilate(mask,kernel,iterations = ite)# 縮小処理
    trimap = np.full(mask.shape,128)# 全ての要素が指定値の配列を生成する
    trimap[eroded != 0] = 255
    trimap[dilated == 0] = 0
    return trimap

trimap = gen_trimap(mask)

# ファイルの名前を設定 & パスの設定
randomName = random.randint(0, 10000)
path = './examples/trimaps/'+image_name
print(path)

plt.imsave(path, trimap) #黒と白 matplotliv形式
img2 = cv.imread(path, 0)
dst = img2.astype(np.uint8)
cv.imwrite(path, dst)# 黒と灰色 openCV2形式
plt.figure(figsize=(20,20))
#plt.imshow(dst)
#plt.show()

del device
gc.collect()

# ------demo.py Start------

warnings.filterwarnings("ignore")

IMG_SCALE = 1. / 255
IMG_MEAN = np.array([0.485, 0.456, 0.406, 0]).reshape((1, 1, 4))
IMG_STD = np.array([0.229, 0.224, 0.225, 1]).reshape((1, 1, 4))

STRIDE = 32
RESTORE_FROM = './pretrained/indexnet_matting.pth.tar'
RESULT_DIR = './examples/mattes'

device = torch.device("cuda:0" if torch.cuda.is_available() else "cpu")

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

net.load_state_dict(pretrained_dict)
net.to(device)
if torch.cuda.is_available():
    net = nn.DataParallel(net)

# switch to eval mode
net.eval()


def read_image(x):
    img_arr = np.array(Image.open(x))
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

        # inference
        start = time()
        outputs = net(inputs)
        end = time()

        outputs = outputs.squeeze().cpu().numpy()
        alpha = cv.resize(outputs, dsize=(w, h), interpolation=cv.INTER_CUBIC)
        alpha = np.clip(alpha, 0, 1) * 255.
        trimap = trimap.squeeze()
        mask = np.equal(trimap, 128).astype(np.float32)
        alpha = (1 - mask) * trimap + mask * alpha

        _, image_name = os.path.split(image_path)
        Image.fromarray(alpha.astype(np.uint8)).save(os.path.join(RESULT_DIR, image_name))
        # Image.fromarray(alpha.astype(np.uint8)).show()

        running_frame_rate = 1 * float(1 / (end - start))  # batch_size = 1
        print('framerate: {0:.2f}Hz'.format(running_frame_rate))

image_path = ['./examples/images/'+image_name]
trimap_path = ['./examples/trimaps/'+image_name]

for image, trimap in zip(image_path, trimap_path):
    inference(image, trimap)

# ------remove_bg2.py Start------

img = cv.imread('./examples/images/'+image_name)
img = img[...,::-1]
matte = cv.imread('./examples/mattes/'+image_name)
h,w,_ = img.shape
bg = np.full_like(img,255) #white background

img = img.astype(float)
bg = bg.astype(float)

matte = matte.astype(float)/255
img = cv.multiply(img, matte)
bg = cv.multiply(bg, 1.0 - matte)
outImage = cv.add(img, bg)

outImage = cv.cvtColor(outImage.astype(np.float32), cv.COLOR_RGB2BGR)#原因はndarrayの型がuint8なことだった。float32に変換すると直った。
cv.imwrite('./examples/'+image_name, outImage)

#plt.imshow(outImage/255) 