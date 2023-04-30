#!/usr/bin/python
# -*- coding: utf-8 -*-
import json
import numpy as np
import cv2
import matplotlib
matplotlib.use("agg")
import matplotlib.pyplot as plt
# "agg" is a non-GUI backend, so you will need to save to a file. – Klaifer Garcia -

import torch
import torchvision
from torchvision import transforms

import ssl
ssl._create_default_https_context = ssl._create_unverified_context
# ↑実行するためのおまじない
# model = torchvision.models.segmentation.deeplabv3_resnet101(pretrained=True)

with open('/var/www/html/getFunction.json') as f:
    df = json.load(f)
#print(df['img_name']) jsonの中に何が格納されているか表示される

image_path = df['img_name']

img = cv2.imread('/var/www/html/scripts/examples/images/'+image_path, -1)
img = img[...,::-1] #BGR->RGB
h,w,_ = img.shape
img = cv2.resize(img,(320,320))

device = torch.device("cuda:0" if torch.cuda.is_available() else "cpu")
try:
    model = torchvision.models.segmentation.deeplabv3_resnet101(pretrained=True)
    print('OK')
except Exception as e:
    print(e)


model = model.to(device)
model.eval()

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
mask = cv2.resize(mask,(w,h))
img = cv2.resize(img,(w,h))
plt.gray()
plt.figure(figsize=(20,20))
#plt.subplot(1,2,1)
#plt.imshow(img)
#plt.subplot(1,2,2)
#plt.imshow(mask);

def gen_trimap(mask,k_size=(5,5),ite=5):
    kernel = np.ones(k_size,np.uint8)
    eroded = cv2.erode(mask,kernel,iterations = ite)# 膨張処理
    dilated = cv2.dilate(mask,kernel,iterations = ite)# 縮小処理
    trimap = np.full(mask.shape,128)# 全ての要素が指定値の配列を生成する
    trimap[eroded != 0] = 255
    trimap[dilated == 0] = 0
    return trimap

#def train(self, mode=True):
##       Sets the module in training mode
#        self.training = mode
#        for module in self.children():
#            module.train(mode)
#        return self

model.train(mode=False)

trimap = gen_trimap(mask)

# ファイルの名前を設定 & パスの設定
path = '/var/www/html/scripts/examples/trimaps/'+image_path
#print(path)

plt.imsave(path, trimap) #黒と白 matplotliv形式
img2 = cv2.imread(path, 0)
dst = img2.astype(np.uint8)
cv2.imwrite(path, dst)# 黒と灰色 openCV2形式

#del dst
#del img2
#del model
#del trimap
#del kernel
#del eroded
#del dilated
#del img
#del mask
#del input_tensor
#del input_batch
#del output
#del preprocess