REPO=harbourmaster
TAG=$(shell git rev-parse --abbrev-ref HEAD)

ifeq (TAG, 'HEAD')
	BUILDNAME=$(REPO)
else
	BUILDNAME=$(REPO):$(TAG)
endif

build:
	sudo docker build -t $(BUILDNAME) .

build-nocache:
	sudo docker build -no-cache=true -t $(BUILDNAME) .
