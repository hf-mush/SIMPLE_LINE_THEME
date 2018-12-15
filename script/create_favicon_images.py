from PIL import Image, ImageDraw


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
source_dir = 'resources/'
source_name = 'favicon'
source_ext = '.png'
favicon_dir = 'favicons/'
favicon_ext = '.png'

# set source image
source = Image.open(source_dir + source_name + source_ext)

# create favicon.ico
img_converted = favicon_dir + 'favicon.ico'
img_resize = source.resize((48, 48))
img_resize.save(img_converted)

# create favicon for default
for size in sizes_icon:
    img_converted = favicon_dir + 'icon-' + \
        str(size) + 'x' + str(size) + favicon_ext
    img_resize = source.resize((int(size), int(size)))
    img_resize.save(img_converted)

# create default size apple-icon
img_converted = favicon_dir + 'apple-touch-icon' + favicon_ext
source.save(img_converted, sizes=[(96, 96)])
img_converted = favicon_dir + 'apple-touch-icon-precomposed' + favicon_ext
source.save(img_converted, sizes=[(96, 96)])

# create favicon for apple
for size in sizes_apple:
    img_resize = source.resize((int(size), int(size)))
    img_converted = favicon_dir + 'apple-touch-icon-' + \
        str(size) + 'x' + str(size) + favicon_ext
    img_resize.save(img_converted)
    img_converted = favicon_dir + 'apple-touch-icon-' + \
        str(size) + 'x' + str(size) + '-precomposed' + favicon_ext
    img_resize.save(img_converted)

# create favicon for android
for size in sizes_android:
    img_converted = favicon_dir + 'android-chrome-' + \
        str(size) + 'x' + str(size) + favicon_ext
    img_resize = source.resize((int(size), int(size)))
    img_resize.save(img_converted)

# create favicon for microsoft
croped = pasted_image(source, 128, 128, 70, 70)
croped.save(favicon_dir+'mstile-70x70.png')
croped = pasted_image(source, 144, 144, 144, 144)
croped.save(favicon_dir+'mstile-144x144.png')
croped = pasted_image(source, 270, 270, 150, 150)
croped.save(favicon_dir+'mstile-150x150.png')
croped = pasted_image(source, 558, 270, 150, 150)
croped.save(favicon_dir+'mstile-310x150.png')
croped = pasted_image(source, 558, 558, 310, 310)
croped.save(favicon_dir+'mstile-310x310.png')
