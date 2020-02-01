# chinchilla

* Chinchilla is Php-amqplib library wrapper and AMQP tool for native php applications.

## About

* We build **Chinchilla** to suitable native php apps that need messaging using Php-amqplib in easier way.

### Installing

## Getting Started
* First create config.php file in your project Directory you have to declare this constants
```
define("AMQP_HOST", "localhost");
define("AMQP_PORT", 5670);
define("AMQP_USERNAME", "rabbitmq");
define("AMQP_PASSWORD", "rabbitmq");
define("AMQP_VHOST", "/");
define("AMQP_LOGIN_METHOD", 'AMQPLAIN');
define("AMQP_LOCAL", 'en_US');
define("AMQP_CONNECTION_TIMEOUT", 120);
define("AMQP_READ_WRITE_TIMEOUT", 120);
define("AMQP_KEEP_ALIVE", true);
define("AMQP_HEART_BEAT", 60);
define("AMQP_CONTEXT", true);
define("AMQP_CHANNEL_RPC_TIMEOUT", 0.0);
define("AMQP_SSL_PROTOCOL", 0.0);
define("AMQP_INSIST", false);
define("AMQP_LOGIN_RESPONSE", null);
define("AMQP_QUEUES", "queues.json"); // full path for your .json queues file. 
```
* create your queues.json file (you can name it what ever you want for now we will assume that you name it as queue.json).
* this is the structure for your queues.json
```
{ 
   "consumers":{ 
      "first_queue_name":{ 
         "connection":"socket",
         "consumer":"FullPathCallBackClass"
      },
        "second_queue_name":{ 
         "connection":"socket",
         "consumer":"FullPathCallBackClass"
      }
   },
   "producers":{ 
      "first_queue_name":{ 
         "connection":"socket",
         "properties":{ 
            "type":"direct",
            "delivery_mode":2
         }
      }
   }
}
```

* example
```
{ 
   "consumers":{ 
      "upload_picture":{ 
         "connection":"socket",
         "callback":"Chinchilla\Consumer\Services\ConsumerAny"
      }
   },
   "producers":{ 
      "upload_picture":{ 
         "connection":"socket",
         "properties":{ 
            "type":"direct",
            "delivery_mode":2
         }
      }
   }
}
```
* now you are ready to use chinchilla ;).
* use QueuePublisher to publish any message you want to any queue by passing message and routing_key

* example
```
    $queuePublisher = new QueuePublisher();
    $queuePublisher->publish("my first message", "upload_picture");
``` 

* use ConsumeQueueMessageService to consume any number of messages form any queue you need by queue name and number of message.
* example
```
    $consumeQueueMessageService = new ConsumeQueueMessageService();
    $consumeQueueMessageService->consumeMessageFormQueue("upload_picture", 5);
``` 

* use QueueDeletionService to delete any queue you want by passing queue name only.
* example
```
    $queueDeletionService = new QueueDeletionService();
    $queueDeletionService->partialDeleteQueue("upload_picture");
    // partialDeleteQueue will delete queue form AMQP broker only
    
    $queueDeletionService = new QueueDeletionService();
    $queueDeletionService->fullDeleteQueue("upload_picture");
    // fullDeleteQueue method will delete queue form AMQP broker and from queues.json too.
``` 


## Running the tests

`$ composer test`

# **please note that** 
* We are well know that this library is not perfect yet, so we are welcoming any contribution.
* For now routing_key must be equal to queue name.
* For now we only support socket connection more  connections type will implemented in the future we will keep the readme updated.
* For now tests are test connections only we will add more tests in the future too.

## Contributing

* Please read [CONTRIBUTING.md](https://github.com/aymanMahgoub/chinchilla/blob/master/CONTRIBUTING.md) for details on our code of conduct, and the process for submitting pull requests to us.

## Authors

* **Ayman Mahgoub** - *Initial work* - [aymanMahgoub](https://github.com/aymanMahgoub)

* See also the list of [contributors](https://github.com/aymanMahgoub/chinchilla/contributors) who participated in this project.

## License

* This project is licensed under the MIT License - see the [LICENSE.md](https://github.com/aymanMahgoub/chinchilla/blob/master/LICENSE.md) file for details

## Acknowledgments

* Inspiration form [Thumper](https://github.com/php-amqplib/Thumper) and [RabbitMqBundle](https://github.com/php-amqplib/RabbitMqBundle).
* Helped a lot to write this README.md [A template to make good README.md](https://gist.github.com/PurpleBooth/109311bb0361f32d87a2). 