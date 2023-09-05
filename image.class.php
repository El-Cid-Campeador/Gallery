<?php 
    class Image {
        private int $exif_imagetype;
        private GdImage $input, $output;
        private int $width, $height;
        private string $dst;

        public function __construct(string $file) {
            $this->exif_imagetype = exif_imagetype($file);

            if ($this->exif_imagetype === IMAGETYPE_JPEG) {
                $this->input = imagecreatefromjpeg($file);
            } else {
                $this->input = imagecreatefrompng($file);
            }

            list($width, $height) = getimagesize($file);

            $this->width = $width;
            $this->height = $height;
        }
        
        public function resizeAuto(int $w, int $h) {
            $this->output = imagecreatetruecolor($w, $h);
        
            imagecopyresized($this->output, $this->input, 0, 0, 0, 0, $w, $h, $this->width, $this->height);
        }

        public function save(string $dest) {
            $this->dst = $dest;

            if ($this->exif_imagetype === IMAGETYPE_JPEG) {
                imagejpeg($this->output, $dest);
            } else {
                imagepng($this->output, $dest);
            }

            imagedestroy($this->input);
            imagedestroy($this->output);
        }

        public function display() {
            $alt = pathinfo($this->dst)['filename'] . '.' . pathinfo($this->dst)['extension'];
            
            echo("<img src=\"http://{$_SERVER['HTTP_HOST']}/{$this->dst}\" alt='$alt' class='image' />");
        }
    }
?>
