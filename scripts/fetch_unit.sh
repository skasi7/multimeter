#!/bin/bash

rrd_name=$1
if [ -z $rrd_name ]
then
  echo "You must provide an database name!" >&2
  exit 1
fi

units_file="$(dirname $0)/../units.cfg"
unit=$( grep $rrd_name $units_file )
if [ $? -eq 0 ]
then
  echo $unit | awk '{ print $2 }'
else
  echo 'ºC'
fi

