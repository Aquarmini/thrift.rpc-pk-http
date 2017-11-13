## Thrift.Rpc与Http效率对比

### 同步调用100次比较 Rpc实例不重连接
~~~
$ php run test:single_request

同步请求接口100次
Laravel处理时间为:2.4605128765106
Phalcon处理时间为:0.23414492607117
Thrift.Rpc处理时间为:0.010225057601929
~~~

### 同步调用100次比较 Rpc实例重连接
~~~
$ php run test:single_request_flush
同步请求接口100次
Laravel处理时间为:7.9443459510803
Phalcon处理时间为:1.6801729202271
Thrift.Rpc处理时间为:0.011620044708252
~~~

### 同步调用100次比较 DB查询
~~~
$ php run test:single_database_request
同步请求接口100次
Laravel处理时间为:5.9485108852386
Phalcon处理时间为:0.26999306678772
Thrift.Rpc处理时间为:0.044579029083252
~~~

### 并发调用
~~~
$ php run test:multi_request@laravel
10个进程，同步请求接口100次
Laravel处理时间为:5.4803171157837

$ php run test:multi_request@phalcon
10个进程，同步请求接口100次
Phalcon处理时间为:0.37838506698608

$ php run test:multi_request@rpc
10个进程，同步请求接口100次
Thrift.Rpc处理时间为:0.045707941055298
~~~