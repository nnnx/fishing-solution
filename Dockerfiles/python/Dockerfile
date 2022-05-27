#FROM python:3.8
#RUN mkdir /py
#WORKDIR /py
#COPY requirements.txt requirements.txt
#RUN pip install --no-cache-dir -r requirements.txt

FROM alpine:3.7

RUN apk upgrade --update && apk add --no-cache python3 python3-dev gcc gfortran freetype-dev musl-dev libpng-dev g++ lapack-dev
RUN pip3 install virtualenv

# Install Python libraries
COPY requirements.txt requirements.txt
RUN pip3 install -r requirements.txt