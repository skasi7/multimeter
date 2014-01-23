#!/bin/bash

probe_script=$1
if [ -z $probe_script ]
then
  echo "You must provide a probe script!" >&2
  exit 1
fi

if [ ! -x $probe_script ]
then
  echo "Probe script '$probe_script' not found or not executable" >&2
  exit 1
fi

rrd_file=$2
if [ -z $rrd_file ]
then
  rrd_file=$(basename $probe_script)
  rrd_file="$(dirname $0)/../rrds/${rrd_file%.*}.rrd"
fi

if [ ! -f $rrd_file ]
then
  echo "RRD filename '$rrd_file' not found" >&2
  exit 1
fi

data=$($probe_script | awk '{ print $2 }' | tr '\n' ':')
rrdtool update $rrd_file N:${data:0:-1}

