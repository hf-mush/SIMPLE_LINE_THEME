from PIL import Image, ImageDraw
import os
from os.path import join, dirname
import sys
import json
import shutil
from distutils.dir_util import copy_tree
from dotenv import load_dotenv


def add_margin(pil_img, top, right, bottom, left, color):
    width, height = pil_img.size
    new_width = width + right + left
    new_height = height + top + bottom
    result = Image.new(pil_img.mode, (new_width, new_height), color)
    result.paste(pil_img, (left, top))
    return result


def pasted_image(source, wrap_width, wrap_height, width, height):
    # get margin
    x_margin = (wrap_width - width) / 2
    y_margin = (wrap_height - height) / 2
    # create image for paste
    croped = source.resize((int(width), int(height)))
    # create image with margin
    resized = add_margin(croped, int(y_margin), int(
        x_margin), int(y_margin), int(x_margin), (0, 0, 0))
    # rectangle for crop
    im_a = Image.new("L", resized.size, 0)
    draw = ImageDraw.Draw(im_a)
    left_x = x_margin
    left_y = y_margin + height - 1
    right_x = x_margin + width - 1
    right_y = y_margin + 1
    draw.rectangle((int(left_x), int(left_y), int(
        right_x), int(right_y)), fill=255)
    # create image with crop rectangle and alpha filter
    img_croped = resized.copy()
    img_croped.putalpha(im_a)
    return img_croped.crop((0, 0, int(wrap_width), int(wrap_height)))


# define resizes
sizes_android = [36, 48, 72, 96, 128, 144, 152, 192, 256, 384, 512]
sizes_apple = [57, 60, 72, 76, 114, 120, 144, 152, 180]
sizes_icon = [16, 24, 32, 36, 48, 72, 96, 128,
              144, 152, 160, 192, 196, 256, 384, 512]
sizes_mstile = [70, 144, 150, 310]

# define path str
root_dir = os.path.abspath(os.path.dirname(sys.argv[0]))
source_dir = root_dir + '/resources'
favicon_dir = root_dir + '/favicons'
source_file = '/favicon.png'

# make directory if not exist favicons/
if not os.path.exists(favicon_dir):
    os.makedirs(favicon_dir)

# set source image for favicon
source = Image.open(source_dir + source_file)

# create favicon.ico
img_converted = '%s/favicon.ico' % favicon_dir
img_resize = source.resize((48, 48))
img_resize.save(img_converted)

# create favicon for default
for size in sizes_icon:
    img_converted = '%s/icon-%dx%d.png' % (favicon_dir, size, size)
    img_resize = source.resize((int(size), int(size)))
    img_resize.save(img_converted)

# create favicon for apple with default size
img_converted = '%s/apple-touch-icon.png' % favicon_dir
source.save(img_converted, sizes=[(96, 96)])
img_converted = '%s/apple-touch-icon-precomposed.png' % favicon_dir
source.save(img_converted, sizes=[(96, 96)])

# create favicon for apple
for size in sizes_apple:
    img_resize = source.resize((int(size), int(size)))
    img_converted = '%s/apple-touch-icon-%dx%d.png' % (favicon_dir, size, size)
    img_resize.save(img_converted)
    img_converted = '%s/apple-touch-icon-%dx%d-precomposed.png' % (
        favicon_dir, size, size)
    img_resize.save(img_converted)

# create favicon for android
for size in sizes_android:
    img_converted = '%s/android-chrome-%dx%d.png' % (favicon_dir, size, size)
    img_resize = source.resize((int(size), int(size)))
    img_resize.save(img_converted)

# create favicon for microsoft
croped = pasted_image(source, 128, 128, 70, 70)
croped.save(favicon_dir+'/mstile-70x70.png')
croped = pasted_image(source, 144, 144, 144, 144)
croped.save(favicon_dir+'/mstile-144x144.png')
croped = pasted_image(source, 270, 270, 150, 150)
croped.save(favicon_dir+'/mstile-150x150.png')
croped = pasted_image(source, 558, 270, 150, 150)
croped.save(favicon_dir+'/mstile-310x150.png')
croped = pasted_image(source, 558, 558, 310, 310)
croped.save(favicon_dir+'/mstile-310x310.png')

# load .env
dotenv_path = join(dirname(__file__), '.env')
load_dotenv(dotenv_path)

# create manifest.json
manifest = {}
manifest['manifest_version'] = 2
manifest['version'] = os.environ.get('THEME_VERSION')
manifest['default_locale'] = 'ja'
manifest['name'] = os.environ.get('BLOG_NAME')
manifest['short_name'] = os.environ.get('BLOG_SHORT_NAME')
manifest['description'] = os.environ.get('BLOG_DESCRIPTION')
manifest['start_url'] = os.environ.get('BLOG_URL')
manifest['display'] = 'standalone'
manifest['orientation'] = 'any'
manifest['background_color'] = os.environ.get("THEME_COLOR")
manifest['theme_color'] = os.environ.get("THEME_COLOR")
manifest['icons'] = []

for size in sizes_android:
    sizes = str(size) + 'x' + str(size)
    icon = {
        'src': '/favicons/android-chrome-' + sizes + '.png',
        'sizes': sizes,
        'type': 'image/png'
    }
    manifest['icons'].append(icon)

# dump json for manifest
manifest_path = favicon_dir + '/manifest.json'

with open(manifest_path, 'w') as f:
    json.dump(manifest, f, indent=4, ensure_ascii=False)

# move sources to favicons
browserconfig_path = favicon_dir + '/browserconfig.xml'
browserconfig_source_path = source_dir + '/browserconfig.xml'

if os.path.exists(browserconfig_source_path):
    shutil.copyfile(browserconfig_source_path, browserconfig_path)

# move favicons to themes
themes_favicons_path = '%s/../themes/%s/favicons' % (
    root_dir, os.environ.get('THEME'))

if os.path.exists(favicon_dir):
    copy_tree(favicon_dir, themes_favicons_path)
