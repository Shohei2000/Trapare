#!/usr/bin/python
# -*- coding: utf-8 -*-
import cv2
import numpy as np
import json
from PIL import Image
import matplotlib
matplotlib.use("agg")
import matplotlib.pyplot as plt

import qrcode

with open('/var/www/html/ASOAR_NEW/getFunction2.json') as f:
    df = json.load(f)
# print(df['img_name']) jsonの中に何が格納されているか表示される

r= df['r']
g= df['g']
b= df['b']
a= df['a']
img_name = df['img_name']
x = df['x_axis']
y = df['y_axis']
z = df['z_axis']
x_cm = df['x_axis_cm']
y_cm = df['y_axis_cm']
z_cm = df['z_axis_cm']
flag = df['transparent']

url1 = './scripts/examples/images/'+img_name
url2 = './scripts/examples/trimaps/'+img_name
url3 = './scripts/examples/mattes/'+img_name
url4 = './scripts/examples/skepng/'+img_name

#デバッグ用
#print(url1)
#print(url2)
#print(url3)
#print(url4)

r_up = int(r) + 10
g_up = int(g) + 10
b_up = int(b) + 10

r_low = int(r) - 10
g_low = int(g) - 10
b_low = int(b) - 10

img = cv2.imread(url1, -1)   # -1はAlphaを含んだ形式(0:グレー, 1:カラー)

color_upper = np.array([float(b), float(g), float(r), float(a)])# 抽出する色の上限(BGR形式)
color_lower = np.array([float(b_low), float(g_low), float(r_low), float(a)])                 # 抽出する色の下限(BGR形式)

img_mask = cv2.inRange(img, color_lower, color_upper)    # 範囲からマスク画像を作成

cv2.imwrite(url2, img_mask)                         # 画像保存
img_bool = cv2.bitwise_not(img_mask)

cv2.imwrite(url3, img_bool)                         # 画像保存

im_rgb = Image.open(url1)
im_a = Image.open(url3)

im_rgb.putalpha(im_a)

im_resize = im_rgb.resize((int(x), int(y)))
im_resize.save(url4)

file_name="./scripts/examples/qr/"+img_name

#パラメータ付与
name = "https://44.194.34.105/ASOAR_NEW/ar.php?name="+img_name+"&x="+x+"&y="+y+"&z="+z+"&x_cm="+x_cm+"&y_cm="+y_cm+"&z_cm="+z_cm+"&flag="+flag;
img = qrcode.make(name)  # QRコード画像データ生成

img.save(file_name)  # 画像ファイルとして保存

#--------------------------------------------
#前回までconcat2.pyで行っていた処理
#ARマーカー作成

img1 = cv2.imread('./scripts/examples/important/pattern-go.png')
img2 = cv2.imread('./scripts/examples/qr/'+img_name)

img2 =cv2.resize(img2,(105,105))

img1 = cv2.cvtColor(img1, cv2.COLOR_BGR2RGB)
img2 = cv2.cvtColor(img2, cv2.COLOR_BGR2RGB)

large_img = img1
small_img = img2

x_offset=250
y_offset=155

large_img[y_offset:y_offset+small_img.shape[0], x_offset:x_offset+small_img.shape[1]] = small_img


plt.imsave("./scripts/examples/armarkers/"+img_name, large_img)
