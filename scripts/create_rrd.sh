#!/bin/bash

probe_script=$1
if [ -z $probe_script ]
then
  echo "You must provide an probe script!" >&2
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

if [ -f $rrd_file ]
then
  echo "File '$rrd_file' already exists, refusing to create rrd there" >&2
  exit 1
fi

data=$($probe_script | awk -F\: '{ print $1 }')
# Data sources from script
# Primary data points: 5m
create_command="rrdtool create $rrd_file --start N --step 300"
for source in $data
do
  create_command="$create_command DS:$source:GAUGE:600:U:U"
done
# Static round robins
# 2:144 -> 1d by 10m
# 12:168 -> 1w by 1h
# 288:365 -> 365d by 1d
round_robins="2:144 12:168 288:365"
for round_robin in $round_robins
do
  create_command="$create_command RRA:AVERAGE:0.5:$round_robin"
done

$create_command

