#!/bin/bash

rrd_file=$1
if [ -z $rrd_file ]
then
  echo "You must provide a RRD filename!" >&2
  exit 1
fi
if [ ! -f $rrd_file ]
then
  echo "RRD filename '$rrd_file' not found!" >&2
  exit 1
fi

template=$2
if [ -z $template ]
then
  echo "You must provide a RRD template!" >&2
  exit 1
fi
data=$3
if [ -z $data ]
then
  echo "You must provide a RRD data!" >&2
  exit 1
fi

rrdtool update "$rrd_file" -t "$template" "N:$data"

