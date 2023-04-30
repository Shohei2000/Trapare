#!/usr/bin/python
# -*- coding: utf-8 -*-
import cv2
import matplotlib
matplotlib.use("agg")
import matplotlib.pyplot as plt
import numpy as np
import json
import qrcode

with open('/var/www/html/ASOAR_NEW/getFunction.json') as f:
    df = json.load(f)
    
id = df['img_name']
    
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

#plt.imsave("./scripts/examples/armarker.png", large_img)
plt.imsave("./scripts/examples/armarkers/"+id, large_img)


#変更しちゃダメ!!