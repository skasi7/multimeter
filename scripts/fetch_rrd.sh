#!/bin/bash

rrd_file=$1
if [ -z $rrd_file ]
then
  echo "You must provide an database filename!" >&2
  exit 1
fi
if [ ! -f $rrd_file ]
then
  echo "RRD database '$rrd_file' not found" >&2
  exit 1
fi

span=$2
if [ -z $span ]
then
  echo "You must provide an span of time!" >&2
  exit 1
fi

# Fetch and remove last line
rrdtool fetch $rrd_file AVERAGE -s end-$span | sed '$d' | \
  ./scripts/rrd_fetch_2_flot.py

