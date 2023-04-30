#!/usr/bin/python
# -*- coding: utf-8 -*-
import json
import cv2
import os
from PIL import Image

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
im_a = Image.open('./scripts/examples/mattes/'+id)

im_rgb.putalpha(im_a)

#if(x == '0') or (y == '0'):
#    im_rgb.save('./scripts/examples/skepng/'+id)
#else:
#    im_resize = im_rgb.resize((int(x), int(y)))
#    im_resize.save('./scripts/examples/skepng/'+id)

im_resize = im_rgb.resize((int(x), int(y)))
im_resize.save('./scripts/examples/skepng/'+id)

file_name="./scripts/examples/qr/"+df['img_name']

#デバッグ用
#print(file_name)

#パラメータ付与
name = "https://44.194.34.105/ASOAR_NEW/ar.php?name="+id+"&x="+x+"&y="+y+"&z="+z+"&x_cm="+x_cm+"&y_cm="+y_cm+"&z_cm="+z_cm+"&flag="+flag;
img = qrcode.make(name)  # QRコード画像データ生成

img.save(file_name)  # 画像ファイルとして保存