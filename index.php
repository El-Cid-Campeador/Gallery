<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Gallery</title>
        <style>
            .gallery {
                display: grid;
                grid-template-columns: repeat(10, 100px);
                gap: 10px;
            }
            
            .image, span, button {
                cursor: pointer;
            }

            .backdrop {
                display: none;
                position: fixed;
                top: 0;
                right: 0;
                bottom: 0;
                left: 0;
                width: 100wh;
                height: 100vh;
                background-color: rgba(0, 0, 0, 0.7);
            }
        
            .info {
                display: block;
                position: fixed;
                top: 50%;
                left: 50%;
                transform: translate(-50%, -50%);
                background-color: #fff;
                padding: 20px;
            }

            .info p, span, button {
                position: absolute;
                z-index: 9999;
            }

            .info p {
                top: 10px;
                left: 10px;
                margin: 5px 10px 10px 0;
            }

            .info img {
                margin: 40px;
            }

            span {
                top: 10px;
                right: 10px;
            }

            button {
                bottom: 10px;
                right: 10px;
                background-color: #567;
                border: none;
                padding: 5px;
                color: #fff;
                border-radius: 2px;
            }
        </style>
    </head>
    <body>
        <div class="gallery">
            <?php require_once('image.class.php'); foreach (new DirectoryIterator('images') as $v): ?>
                <?php 
                    if ($v->isDot() || ($v->getExtension() !== 'jpg' && $v->getExtension() !== 'jpeg' && $v->getExtension() !== 'png')) {
                        continue;
                    }
    
                    $filename = $v->getFilename();
                    $img = new Image("./images/" . $filename);
                    $img->resizeAuto(100, 100);
                    $img->save("./thumbnails/" . $filename);
                    $img->display();
                ?>
                <div class="backdrop" id=<?= $filename ?> >
                    <div class="info">
                        <p><?= $filename ?></p>
                        <span class="close">X</span>
                        <img src=<?= "http://{$_SERVER['HTTP_HOST']}/images/{$filename}" ?> alt=<?= $filename ?> />
                        <button>Close</button>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>

        <script defer>
            const images = document.getElementsByClassName('image');
            const infos = document.getElementsByClassName('backdrop');
            const closers = document.getElementsByClassName('close');
            const buttons = document.querySelectorAll('button');

            for (let i = 0; i < images.length; i += 1) {
                images[i].addEventListener('click', (e) => {
                    infos[i].style.display = 'block';
                });

                closers[i].addEventListener('click', () => {
                    infos[i].style.display = 'none';
                });

                buttons[i].addEventListener('click', () => {
                    infos[i].style.display = 'none';
                });
            }
        </script>
    </body>
</html>
