<?php

namespace App\Admin\Controllers;

use App\Http\Controllers\Controller;
use Encore\Admin\Layout\Content;
use Encore\Admin\Widgets\Box;
use Encore\Admin\Widgets\Callout;
use Encore\Admin\Widgets\Form;

class CodemirrorController extends Controller
{
    public function clike(Content $content)
    {
        $form = new Form();
        $form->clang('clang')->default($this->defaultValues['clang']);
        $form->cpp('cpp')->default($this->defaultValues['clang']);
        $form->objectivec('objectivec')->default($this->defaultValues['objectivec']);
        $form->java('java')->default($this->defaultValues['java']);
        $form->kotlin('kotlin')->default($this->defaultValues['kotlin']);
        $form->scala('scala')->default($this->defaultValues['scala']);
        $form->ceylon('ceylon')->default($this->defaultValues['ceylon']);

        return $content
            ->title($title = 'Clike Editor')
            ->row($this->info('https://github.com/laravel-admin-extensions/clike-editor', $title))
            ->row(new Box($title, $form));
    }

    public function php(Content $content)
    {
        $form = new Form();
        $form->php('php')->default($this->defaultValues['php']);

        return $content
            ->title($title = 'PHP Editor')
            ->row($this->info('https://github.com/laravel-admin-extensions/php-editor', $title))
            ->row(new Box($title, $form));
    }

    public function js(Content $content)
    {
        $form = new Form();
        $form->js('js')->default($this->defaultValues['js']);
        $form->json('json')->default($this->defaultValues['json']);
        $form->jsond('jsond')->default($this->defaultValues['jsond']);
        $form->typescript('typescript')->default($this->defaultValues['typescript']);

        return $content
            ->title($title = 'Javascript Editor')
            ->row($this->info('https://github.com/laravel-admin-extensions/js-editor', $title))
            ->row(new Box($title, $form));
    }

    public function python(Content $content)
    {
        $form = new Form();
        $form->python('python3')->default($this->defaultValues['python']);
        $form->python('python2')->version(2)->default($this->defaultValues['python']);

        return $content
            ->title($title = 'Python Editor')
            ->row($this->info('https://github.com/laravel-admin-extensions/python-editor', $title))
            ->row(new Box($title, $form));
    }

    protected function info($url, $title)
    {
        $content = "<a href=\"{$url}\" target='_blank'>{$url}</a>";

        return new Callout($content, $title, 'info');
    }

    protected $defaultValues = [
        'clang' => <<<'CODE'
/* C demo code */

#include <zmq.h>
#include <pthread.h>
#include <semaphore.h>
#include <time.h>
#include <stdio.h>
#include <fcntl.h>
#include <malloc.h>

typedef struct {
  void* arg_socket;
  zmq_msg_t* arg_msg;
  char* arg_string;
  unsigned long arg_len;
  int arg_int, arg_command;

  int signal_fd;
  int pad;
  void* context;
  sem_t sem;
} acl_zmq_context;

#define p(X) (context->arg_##X)

void* zmq_thread(void* context_pointer) {
  acl_zmq_context* context = (acl_zmq_context*)context_pointer;
  char ok = 'K', err = 'X';
  int res;

  while (1) {
    while ((res = sem_wait(&context->sem)) == EINTR);
    if (res) {write(context->signal_fd, &err, 1); goto cleanup;}
    switch(p(command)) {
    case 0: goto cleanup;
    case 1: p(socket) = zmq_socket(context->context, p(int)); break;
    case 2: p(int) = zmq_close(p(socket)); break;
    case 3: p(int) = zmq_bind(p(socket), p(string)); break;
    case 4: p(int) = zmq_connect(p(socket), p(string)); break;
    case 5: p(int) = zmq_getsockopt(p(socket), p(int), (void*)p(string), &p(len)); break;
    case 6: p(int) = zmq_setsockopt(p(socket), p(int), (void*)p(string), p(len)); break;
    case 7: p(int) = zmq_send(p(socket), p(msg), p(int)); break;
    case 8: p(int) = zmq_recv(p(socket), p(msg), p(int)); break;
    case 9: p(int) = zmq_poll(p(socket), p(int), p(len)); break;
    }
    p(command) = errno;
    write(context->signal_fd, &ok, 1);
  }
 cleanup:
  close(context->signal_fd);
  free(context_pointer);
  return 0;
}

void* zmq_thread_init(void* zmq_context, int signal_fd) {
  acl_zmq_context* context = malloc(sizeof(acl_zmq_context));
  pthread_t thread;

  context->context = zmq_context;
  context->signal_fd = signal_fd;
  sem_init(&context->sem, 1, 0);
  pthread_create(&thread, 0, &zmq_thread, context);
  pthread_detach(thread);
  return context;
}

CODE
        ,

        'cpp' => <<<'CODE'
#include <iostream>
#include "mystuff/util.h"

namespace {
enum Enum {
  VAL1, VAL2, VAL3
};

char32_t unicode_string = U"\U0010FFFF";
string raw_string = R"delim(anything
you
want)delim";

int Helper(const MyType& param) {
  return 0;
}
} // namespace

class ForwardDec;

template <class T, class V>
class Class : public BaseClass {
  const MyType<T, V> member_;

 public:
  const MyType<T, V>& Method() const {
    return member_;
  }

  void Method2(MyType<T, V>* value);
}

template <class T, class V>
void Class::Method2(MyType<T, V>* value) {
  std::out << 1 >> method();
  value->Method3(member_);
  member_ = value;
}

CODE
        ,


        'objectivec' => <<<'CODE'
/*
This is a longer comment
That spans two lines
*/

#import <Test/Test.h>
@implementation YourAppDelegate

// This is a one-line comment

- (BOOL)application:(UIApplication *)application didFinishLaunchingWithOptions:(NSDictionary *)launchOptions{
  char myString[] = "This is a C character array";
  int test = 5;
  return YES;
}

CODE
        ,

        'java' => <<<'CODE'
import com.demo.util.MyType;
import com.demo.util.MyInterface;

public enum Enum {
  VAL1, VAL2, VAL3
}

public class Class<T, V> implements MyInterface {
  public static final MyType<T, V> member;
  
  private class InnerClass {
    public int zero() {
      return 0;
    }
  }

  @Override
  public MyType method() {
    return member;
  }

  public void method2(MyType<T, V> value) {
    method();
    value.method3();
    member = value;
  }
}


CODE
        ,

        'scala' => <<<'CODE'
object FilterTest extends App {
  def filter(xs: List[Int], threshold: Int) = {
    def process(ys: List[Int]): List[Int] =
      if (ys.isEmpty) ys
      else if (ys.head < threshold) ys.head :: process(ys.tail)
      else process(ys.tail)
    process(xs)
  }
  println(filter(List(1, 9, 2, 8, 3, 7, 4), 5))
}

CODE
        ,

        'kotlin' => <<<'CODE'
package org.wasabi.http

import java.util.concurrent.Executors
import java.net.InetSocketAddress
import org.wasabi.app.AppConfiguration
import io.netty.bootstrap.ServerBootstrap
import io.netty.channel.nio.NioEventLoopGroup
import io.netty.channel.socket.nio.NioServerSocketChannel
import org.wasabi.app.AppServer

public class HttpServer(private val appServer: AppServer) {

    val bootstrap: ServerBootstrap
    val primaryGroup: NioEventLoopGroup
    val workerGroup:  NioEventLoopGroup

    init {
        // Define worker groups
        primaryGroup = NioEventLoopGroup()
        workerGroup = NioEventLoopGroup()

        // Initialize bootstrap of server
        bootstrap = ServerBootstrap()

        bootstrap.group(primaryGroup, workerGroup)
        bootstrap.channel(javaClass<NioServerSocketChannel>())
        bootstrap.childHandler(NettyPipelineInitializer(appServer))
    }

    public fun start(wait: Boolean = true) {
        val channel = bootstrap.bind(appServer.configuration.port)?.sync()?.channel()

        if (wait) {
            channel?.closeFuture()?.sync()
        }
    }

    public fun stop() {
        // Shutdown all event loops
        primaryGroup.shutdownGracefully()
        workerGroup.shutdownGracefully()

        // Wait till all threads are terminated
        primaryGroup.terminationFuture().sync()
        workerGroup.terminationFuture().sync()
    }
}

CODE
        ,

        'ceylon' => <<<'CODE'
"Produces the [[stream|Iterable]] that results from repeated
 application of the given [[function|next]] to the given
 [[first]] element of the stream, until the function first
 returns [[finished]]. If the given function never returns 
 `finished`, the resulting stream is infinite.

 For example:

     loop(0)(2.plus).takeWhile(10.largerThan)

 produces the stream `{ 0, 2, 4, 6, 8 }`."
tagged("Streams")
shared {Element+} loop<Element>(
        "The first element of the resulting stream."
        Element first)(
        "The function that produces the next element of the
         stream, given the current element. The function may
         return [[finished]] to indicate the end of the 
         stream."
        Element|Finished next(Element element))
    => let (start = first)
    object satisfies {Element+} {
        first => start;
        empty => false;
        function nextElement(Element element)
                => next(element);
        iterator()
                => object satisfies Iterator<Element> {
            variable Element|Finished current = start;
            shared actual Element|Finished next() {
                if (!is Finished result = current) {
                    current = nextElement(result);
                    return result;
                }
                else {
                    return finished;
                }
            }
        };
    };

CODE
        ,

        'php' => <<<'CODE'
        
<?php
$a = array('a' => 1, 'b' => 2, 3 => 'c');

echo "$a[a] ${a[3] /* } comment */} {$a[b]} \$a[a]";

function hello($who) {
	return "Hello $who!";
}
?>
<p>The program says <?= hello("World") ?>.</p>
<script>
	alert("And here is some JS code"); // also colored
</script>

CODE
        ,

        'python' => <<<'CODE'
# Literals
1234
0.0e101
.123
0b01010011100
0o01234567
0x0987654321abcdef
7
2147483647
3L
79228162514264337593543950336L
0x100000000L
79228162514264337593543950336
0xdeadbeef
3.14j
10.j
10j
.001j
1e100j
3.14e-10j


# String Literals
'For\''
"God\""
"""so loved
the world"""
'''that he gave
his only begotten\' '''
'that whosoever believeth \
in him'
''

# Identifiers
__a__
a.b
a.b.c

#Unicode identifiers on Python3
# a = x\ddot
a⃗ = ẍ
# a = v\dot
a⃗ = v̇

#F\vec = m \cdot a\vec
F⃗ = m•a⃗ 

# Operators
+ - * / % & | ^ ~ < >
== != <= >= <> << >> // **
and or not in is

#infix matrix multiplication operator (PEP 465)
A @ B

# Delimiters
() [] {} , : ` = ; @ .  # Note that @ and . require the proper context on Python 2.
+= -= *= /= %= &= |= ^=
//= >>= <<= **=

# Keywords
as assert break class continue def del elif else except
finally for from global if import lambda pass raise
return try while with yield

# Python 2 Keywords (otherwise Identifiers)
exec print

# Python 3 Keywords (otherwise Identifiers)
nonlocal

# Types
bool classmethod complex dict enumerate float frozenset int list object
property reversed set slice staticmethod str super tuple type

# Python 2 Types (otherwise Identifiers)
basestring buffer file long unicode xrange

# Python 3 Types (otherwise Identifiers)
bytearray bytes filter map memoryview open range zip

# Some Example code
import os
from package import ParentClass

@nonsenseDecorator
def doesNothing():
    pass

class ExampleClass(ParentClass):
    @staticmethod
    def example(inputStr):
        a = list(inputStr)
        a.reverse()
        return ''.join(a)

    def __init__(self, mixin = 'Hello'):
        self.mixin = mixin

# Python 3.6 f-strings (https://www.python.org/dev/peps/pep-0498/)
f'My name is {name}, my age next year is {age+1}, my anniversary is {anniversary:%A, %B %d, %Y}.'
f'He said his name is {name!r}.'
f"""He said his name is {name!r}."""
f'{"quoted string"}'
f'{{ {4*10} }}'
f'This is an error }'
f'This is ok }}'
fr'x={4*10}\n'

CODE
        ,

        'js' => <<<'CODE'
// Demo code (the actual new parser character stream implementation)

function StringStream(string) {
  this.pos = 0;
  this.string = string;
}

StringStream.prototype = {
  done: function() {return this.pos >= this.string.length;},
  peek: function() {return this.string.charAt(this.pos);},
  next: function() {
    if (this.pos < this.string.length)
      return this.string.charAt(this.pos++);
  },
  eat: function(match) {
    var ch = this.string.charAt(this.pos);
    if (typeof match == "string") var ok = ch == match;
    else var ok = ch && match.test ? match.test(ch) : match(ch);
    if (ok) {this.pos++; return ch;}
  },
  eatWhile: function(match) {
    var start = this.pos;
    while (this.eat(match));
    if (this.pos > start) return this.string.slice(start, this.pos);
  },
  backUp: function(n) {this.pos -= n;},
  column: function() {return this.pos;},
  eatSpace: function() {
    var start = this.pos;
    while (/\s/.test(this.string.charAt(this.pos))) this.pos++;
    return this.pos - start;
  },
  match: function(pattern, consume, caseInsensitive) {
    if (typeof pattern == "string") {
      function cased(str) {return caseInsensitive ? str.toLowerCase() : str;}
      if (cased(this.string).indexOf(cased(pattern), this.pos) == this.pos) {
        if (consume !== false) this.pos += str.length;
        return true;
      }
    }
    else {
      var match = this.string.slice(this.pos).match(pattern);
      if (match && consume !== false) this.pos += match[0].length;
      return match;
    }
  }
};


CODE
        ,

        'json' => <<<'CODE'
{
  "@context": {
    "name": "http://schema.org/name",
    "description": "http://schema.org/description",
    "image": {
      "@id": "http://schema.org/image",
      "@type": "@id"
    },
    "geo": "http://schema.org/geo",
    "latitude": {
      "@id": "http://schema.org/latitude",
      "@type": "xsd:float"
    },
    "longitude": {
      "@id": "http://schema.org/longitude",
      "@type": "xsd:float"
    },
    "xsd": "http://www.w3.org/2001/XMLSchema#"
  },
  "name": "The Empire State Building",
  "description": "The Empire State Building is a 102-story landmark in New York City.",
  "image": "http://www.civil.usherbrooke.ca/cours/gci215a/empire-state-building.jpg",
  "geo": {
    "latitude": "40.75",
    "longitude": "73.98"
  }
}


CODE
        ,

        'jsond' => <<<'CODE'
{
  "@context": {
    "name": "http://schema.org/name",
    "description": "http://schema.org/description",
    "image": {
      "@id": "http://schema.org/image",
      "@type": "@id"
    },
    "geo": "http://schema.org/geo",
    "latitude": {
      "@id": "http://schema.org/latitude",
      "@type": "xsd:float"
    },
    "longitude": {
      "@id": "http://schema.org/longitude",
      "@type": "xsd:float"
    },
    "xsd": "http://www.w3.org/2001/XMLSchema#"
  },
  "name": "The Empire State Building",
  "description": "The Empire State Building is a 102-story landmark in New York City.",
  "image": "http://www.civil.usherbrooke.ca/cours/gci215a/empire-state-building.jpg",
  "geo": {
    "latitude": "40.75",
    "longitude": "73.98"
  }
}


CODE
        ,

        'typescript' => <<<'CODE'
class Greeter {
  greeting: string;
  constructor (message: string) {
    this.greeting = message;
  }
  greet() {
    return "Hello, " + this.greeting;
  }
}   

var greeter = new Greeter("world");

var button = document.createElement('button')
button.innerText = "Say Hello"
button.onclick = function() {
  alert(greeter.greet())
}

document.body.appendChild(button)

CODE
        ,
    ];
}
