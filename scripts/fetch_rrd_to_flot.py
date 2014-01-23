#!/usr/bin/python

import datetime
import fileinput
import itertools
import json

if __name__ == '__main__':
    line_generator = fileinput.input()
    serie_names = next(line_generator).strip().split()
    _ = next(line_generator)

    time_serie = list()
    data_series = list()
    for line in line_generator:
        time, data = line.strip().split(': ', 1)
        time_serie.append(int(time) * 1000)
        data_series.append(map(float, data.replace(',', '.').split()))
    data_series = zip(*data_series)

    # JS/Json encode
    print ', '.join(['{label: "%s", data: %s}' % (
        serie_name, json.dumps(zip(time_serie, data_serie)))
        for serie_name, data_serie in
        itertools.izip(serie_names, data_series)])

