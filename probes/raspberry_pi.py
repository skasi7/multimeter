#!/usr/bin/python

import subprocess

if __name__ == '__main__':
    cpu_temp = subprocess.check_output(['cat', '/sys/class/thermal/thermal_zone0/temp']).strip()
    cpu_temp = int(cpu_temp) / 1000.0
    gpu_temp = subprocess.check_output(['/opt/vc/bin/vcgencmd', 'measure_temp']).strip()
    gpu_temp = float(gpu_temp[5:9])
    print 'CPU: %.2f' % cpu_temp
    print 'GPU: %.2f' % gpu_temp

