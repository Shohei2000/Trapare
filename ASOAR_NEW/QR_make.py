#!/usr/bin/python
# -*- coding: utf-8 -*-
import json
import cv2
import os
from PIL import Image
import matplotlib
matplotlib.use("agg")
import matplotlib.pyplot as plt

import qrcode

with open('/var/www/html/ASOAR_NEW/getFunction.json') as f:
    df = json.load(f)
    
id = df['img_name']
x = df['x_axis']
y = df['y_axis']
z = df['z_axis']
x_cm = df['x_axis_cm']
y_cm = df['y_axis_cm']
z_cm = df['z_axis_cm']
flag = df['transparent']

#デバッグ用
#print(id)
#print(x)
#print(y)
#print(z)

im_rgb = Image.open('./scripts/examples/images/'+id)

#ASOAR_ImageUplodeで指定したサイズに戻す
im_resize = im_rgb.resize((int(x), int(y)))

im_resize.save('./scripts/examples/images/'+id)

file_name="./scripts/examples/qr/"+df['img_name']

#パラメータ付与
name = "https://44.194.34.105/ASOAR_NEW/ar.php?name="+id+"&x="+x+"&y="+y+"&z="+z+"&x_cm="+x_cm+"&y_cm="+y_cm+"&z_cm="+z_cm+"&flag="+flag;
img = qrcode.make(name)  # QRコード画像データ生成

img.save(file_name)  # 画像ファイルとして保存

#-------------------------------------------

img1 = cv2.imread('./scripts/examples/important/pattern-go.png')
img2 = cv2.imread('./scripts/examples/qr/'+id)

img2 =cv2.resize(img2,(105,105))

img1 = cv2.cvtColor(img1, cv2.COLOR_BGR2RGB)
img2 = cv2.cvtColor(img2, cv2.COLOR_BGR2RGB)

large_img = img1
small_img = img2

x_offset=250
y_offset=155

large_img[y_offset:y_offset+small_img.shape[0], x_offset:x_offset+small_img.shape[1]] = small_img

plt.imsave("./scripts/examples/armarkers/"+id, large_img)