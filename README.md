```bash
$ docker build -t php_apache:latest .
$ docker run -d --name gallery_site -p 8001:80 -v "$PWD":/var/www/html php_apache:latest
```
