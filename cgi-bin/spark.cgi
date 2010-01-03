#!/usr/bin/env python

"""spark.cgi

A web service for generating sparklines.

Requires the Python Imaging Library 
"""

__author__ = "Joe Gregorio (joe@bitworking.org)"
__copyright__ = "Copyright 2005, Joe Gregorio"
__contributors__ = []
__version__ = "1.0.0 $Rev:$"
__license__ = "MIT"
__history__ = """

"""

import cgi
import cgitb
import sys
import os

cgitb.enable()

import Image, ImageDraw
import StringIO
import urllib


def plot_sparkline_discrete(results, args):
   """The source data is a list of values between
      0 and 100. Values greater than 95
      are displayed in red, otherwise they are displayed
      in green"""
   height = int(args.get('height', '14'))
   upper = int(args.get('upper', '50'))
   below_color = args.get('below-color', 'gray')
   above_color = args.get('above-color', 'red')
   im = Image.new("RGB", (len(results)*2-1, height), 'white')
   draw = ImageDraw.Draw(im)
   for (r, i) in zip(results, range(0, len(results)*2, 2)):
      color = (r >= upper) and above_color or below_color
      draw.line((i, im.size[1]-r/(101.0/(height-4))-4, i, (im.size[1]-r/(101.0/(height-4)))), fill=color)
   del draw                                                      
   f = StringIO.StringIO()
   im.save(f, "PNG")
   return f.getvalue()

def plot_sparkline_smooth(results, args):
   step = int(args.get('step', '2'))
   height = int(args.get('height', '20'))
   im = Image.new("RGB", ((len(results)-1)*step+4, height), 'white')
   draw = ImageDraw.Draw(im)
   coords = zip(range(1,len(results)*step+1, step), [height - 3  - y/(101.0/(height-4)) for y in results])
   draw.line(coords, fill="#888888")
   min_color = args.get('min-color', '#0000FF')
   max_color = args.get('max-color', '#00FF00')
   last_color = args.get('last-color', '#FF0000')
   has_min = args.get('min-m', 'false')
   has_max = args.get('max-m', 'false')
   has_last = args.get('last-m', 'false')
   if has_min == 'true':
      min_pt = coords[results.index(min(results))]
      draw.rectangle([min_pt[0]-1, min_pt[1]-1, min_pt[0]+1, min_pt[1]+1], fill=min_color)
   if has_max == 'true':
      max_pt = coords[results.index(max(results))]
      draw.rectangle([max_pt[0]-1, max_pt[1]-1, max_pt[0]+1, max_pt[1]+1], fill=max_color)
   if has_last == 'true':
      end = coords[-1]
      draw.rectangle([end[0]-1, end[1]-1, end[0]+1, end[1]+1], fill=last_color)
   del draw 
   f = StringIO.StringIO()
   im.save(f, "PNG")
   return f.getvalue()

def plot_error(results, args):
   im = Image.new("RGB", (40, 15), 'white')
   draw = ImageDraw.Draw(im)
   draw.line((0, 0) + im.size, fill="red")
   draw.line((0, im.size[1], im.size[0], 0), fill="red")
   del draw                                                      
   f = StringIO.StringIO()
   im.save(sys.stdout, "PNG")
   return f.getvalue()

def ok():
    print "Content-type: image/png"
    print "Status: 200 Ok"
    print "ETag: " + str(hash(os.environ['QUERY_STRING'] + __version__))
    print ""

def error(status="Status: 400 Bad Request"):
    print "Content-type: image/png"
    print status 
    print ""
    sys.stdout.write(plot_error([], {}))
    sys.exit()

def cgi_param(form, name, default):
    return form.has_key(name) and form[name].value or default

plot_types = {'discrete': plot_sparkline_discrete, 
                'smooth': plot_sparkline_smooth,
                 'error': plot_error
    }

if not os.environ['REQUEST_METHOD'] in ['GET', 'HEAD']:
    error("Status: 405 Method Not Allowed")
form = cgi.FieldStorage()
raw_data = cgi_param(form, 'd', '')
if not raw_data:
    error()
data = [int(d) for d in raw_data.split(",") if d]
if min(data) < 0 or max(data) > 100:
    error()
args = dict([(key, form[key].value) for key in form.keys()])
type = cgi_param(form, 'type', 'discrete')
if not plot_types.has_key(type):
    error()

ok()
sys.stdout.write(plot_types[type](data, args))

