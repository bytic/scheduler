C:28:"Bytic\Scheduler\Events\Event":3111:{a:14:{s:7:"pingers";a:1:{s:12:"healthchecks";a:3:{i:0;a:1:{s:7:"trigger";s:6:"before";}i:1;a:1:{s:7:"trigger";s:5:"after";}i:2;a:1:{s:7:"trigger";s:7:"success";}}}s:15:"beforeCallbacks";a:1:{i:0;C:32:"Opis\Closure\SerializableClosure":2580:{a:5:{s:3:"use";a:2:{s:11:"destination";s:12:"healthchecks";s:7:"options";a:1:{s:7:"trigger";s:6:"before";}}s:8:"function";s:273:"function () use ($destination, $options) {
            /** @var PingerManager $manager */
            $manager = \Nip\Container\Container::getInstance()->get(\Bytic\Scheduler\Pinger\PingerManager::class);
            $manager::ping($destination, $this, $options);
        }";s:5:"scope";s:28:"Bytic\Scheduler\Events\Event";s:4:"this";C:28:"Bytic\Scheduler\Events\Event":2022:{a:14:{s:7:"pingers";a:1:{s:12:"healthchecks";a:3:{i:0;a:1:{s:7:"trigger";s:6:"before";}i:1;a:1:{s:7:"trigger";s:5:"after";}i:2;a:1:{s:7:"trigger";s:7:"success";}}}s:15:"beforeCallbacks";a:1:{i:0;r:12;}s:14:"afterCallbacks";a:2:{i:0;C:32:"Opis\Closure\SerializableClosure":519:{a:5:{s:3:"use";a:2:{s:11:"destination";s:12:"healthchecks";s:7:"options";a:1:{s:7:"trigger";s:5:"after";}}s:8:"function";s:273:"function () use ($destination, $options) {
            /** @var PingerManager $manager */
            $manager = \Nip\Container\Container::getInstance()->get(\Bytic\Scheduler\Pinger\PingerManager::class);
            $manager::ping($destination, $this, $options);
        }";s:5:"scope";s:28:"Bytic\Scheduler\Events\Event";s:4:"this";r:20;s:4:"self";s:32:"00000000163f4666000000003ebc661d";}}i:1;C:32:"Opis\Closure\SerializableClosure":932:{a:5:{s:3:"use";a:1:{s:8:"callback";C:32:"Opis\Closure\SerializableClosure":521:{a:5:{s:3:"use";a:2:{s:11:"destination";s:12:"healthchecks";s:7:"options";a:1:{s:7:"trigger";s:7:"success";}}s:8:"function";s:273:"function () use ($destination, $options) {
            /** @var PingerManager $manager */
            $manager = \Nip\Container\Container::getInstance()->get(\Bytic\Scheduler\Pinger\PingerManager::class);
            $manager::ping($destination, $this, $options);
        }";s:5:"scope";s:28:"Bytic\Scheduler\Events\Event";s:4:"this";r:20;s:4:"self";s:32:"00000000163f4661000000003ebc661d";}}}s:8:"function";s:189:"function () use ($callback) {
            if ($this->getProcess()->isSuccessful()) {
                \Bytic\Scheduler\Runner\Invoker::call($callback, [$this], true);
            }
        }";s:5:"scope";s:28:"Bytic\Scheduler\Events\Event";s:4:"this";r:20;s:4:"self";s:32:"00000000163f4660000000003ebc661d";}}}s:7:"command";s:6:"php -v";s:10:"expression";s:9:"* * * * *";s:6:"driver";s:8:"internal";s:10:"identifier";N;s:11:"description";N;s:6:"output";s:3:"NUL";s:12:"outputStream";N;s:11:"wholeOutput";a:0:{}s:4:"user";N;s:3:"cwd";N;s:7:"process";N;}}s:4:"self";s:32:"00000000163f4667000000003ebc661d";}}}s:14:"afterCallbacks";a:2:{i:0;r:33;i:1;r:43;}s:7:"command";s:6:"php -v";s:10:"expression";s:9:"* * * * *";s:6:"driver";s:8:"internal";s:10:"identifier";N;s:11:"description";N;s:6:"output";s:3:"NUL";s:12:"outputStream";N;s:11:"wholeOutput";a:0:{}s:4:"user";N;s:3:"cwd";N;s:7:"process";N;}}