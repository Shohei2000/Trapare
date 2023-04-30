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

im_rgb.save('./scripts/examples/skepng/'+id)