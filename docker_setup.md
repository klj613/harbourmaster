Docker setup
============

Building an image
-----------------

Use `make build` to build an docker image or `make build-nocache` to
re-run all the steps skipping the cache. The repository name is
'harbourmaster' by default and the tag name is the current branch you
are on. If you wish to override this then call the `docker build`
command yourself by having a look at the makefile.

Running an image
----------------

### Production

`docker run -d harbourmaster:master`

### Development

`docker run -d -v /path/to/the/hosts/app/dir:/var/www/harbourmaster harbourmaster:master`

e.g.

`docker run -d -v `pwd`:/var/www/harborumaster harbourmaster:master`

By using a mount point for the app you can now edit the files on the host and it will
be used by the docker container.

You will have to set up permissions on the host for the apache user in the docker container
to READ/WRITE. I would suggest setting it up with:

- `sudo chown YOUR_USER:33 /path/to/the/app/dir -R` - The '33' is normally the apache / http 
   user. You can be specific and use which ever username your distro uses.
- `sudo chmod 664 /path/to/the/app/dir -R`
- `sudo chmod 764 /path/to/the/app/dir`
- `sudo find /path/to/the/app/dir -type d -exec chmod +x {} +`
- Disclaimer: I am no permission guru.

### Database considerations

Since docker images are static (e.g. a git commit each step). When you restart the docker container
you will lose your database!!! For this I use mount points to mount to a folder in the host. Below
is a example which would have to be done on every `docker run`. I would suggest not sharing a mount
point for multiple docker containers (instances) as they would possibly conflict. Therefore I would
use:

`docker run -d -v /mnt/harbourmaster/mongod_1:var/lib/mongodb -v `pwd`:/var/www/harbourmaster harbourmaster:master`

### SSH access

You could install ssh server on the container (maybe will for production at some point) however currently to get
into the docker container for 'development' i would do (when I start the container):

`docker run -i -t -v /mnt/harbourmaster/mongod_1:/var/lib/mongodb -v `pwd`:/var/www/harbourmaster harbourmaster:master /bin/bash`

and then run `supervisord` to start apache/mongo. To restart apache/mongo you will then do:

- `supervisorctl restart apache2`
- `supervisorctl restart mongod`

### Restoring a database

To get a database dump into mongo I would run /bin/bash inside a
docker container (see 'SSH access' above) and run mongorestore.

The way I would get a database dump file into the container
is to put the file(s) into the hosts app dir which should
be bind mounted to the docker container.
