O:28:"Bytic\Scheduler\Events\Event":15:{s:7:"pingers";a:1:{s:12:"healthchecks";a:3:{i:0;a:1:{s:7:"trigger";s:6:"before";}i:1;a:1:{s:7:"trigger";s:5:"after";}i:2;a:1:{s:7:"trigger";s:7:"success";}}}s:15:"beforeCallbacks";a:1:{i:0;s:2409:"O:28:"Opis\Closure\PriorityWrapper":2:{i:0;a:1:{i:0;O:16:"Opis\Closure\Box":2:{i:0;i:3;i:1;a:2:{i:0;s:28:"Bytic\Scheduler\Events\Event";i:1;a:15:{s:7:"pingers";a:1:{s:12:"healthchecks";a:3:{i:0;a:1:{s:7:"trigger";s:6:"before";}i:1;a:1:{s:7:"trigger";s:5:"after";}i:2;a:1:{s:7:"trigger";s:7:"success";}}}s:15:"beforeCallbacks";a:1:{i:0;O:16:"Opis\Closure\Box":2:{i:0;i:1;i:1;a:4:{s:4:"info";a:5:{s:3:"key";s:32:"7ed9d0cc7ac7801a5fce084c67871bba";s:6:"header";s:111:"namespace Bytic\Scheduler\Events\Traits;
use Bytic\Scheduler\Pinger\PingerManager,
Nip\Container\Container;";s:4:"body";s:234:"function () use ($destination, $options) {
            /** @var PingerManager $manager */
$manager = Container::getInstance()->get(PingerManager::class);
            $manager::ping($destination, $this, $options);
}";s:3:"use";a:2:{i:0;s:11:"destination";i:1;s:7:"options";}s:5:"flags";i:4;}s:4:"this";r:3;s:5:"scope";s:28:"Bytic\Scheduler\Events\Event";s:4:"vars";a:2:{s:11:"destination";s:12:"healthchecks";s:7:"options";a:1:{s:7:"trigger";s:6:"before";}}}}}s:14:"afterCallbacks";a:2:{i:0;O:16:"Opis\Closure\Box":2:{i:0;i:1;i:1;a:4:{s:4:"info";R:20;s:4:"this";r:3;s:5:"scope";s:28:"Bytic\Scheduler\Events\Event";s:4:"vars";a:2:{s:11:"destination";s:12:"healthchecks";s:7:"options";a:1:{s:7:"trigger";s:5:"after";}}}}i:1;O:16:"Opis\Closure\Box":2:{i:0;i:1;i:1;a:4:{s:4:"info";a:5:{s:3:"key";s:32:"a0efdf06c6802f5b41021195a4e962ac";s:6:"header";s:76:"namespace Bytic\Scheduler\Events\Traits;
use Bytic\Scheduler\Runner\Invoker;";s:4:"body";s:178:"function ($event = null) use ($callback) {
if ($this->getProcess()->isSuccessful()) {
Invoker::call($callback, [$this], true);
}
}";s:3:"use";a:1:{i:0;s:8:"callback";}s:5:"flags";i:4;}s:4:"this";r:3;s:5:"scope";s:28:"Bytic\Scheduler\Events\Event";s:4:"vars";a:1:{s:8:"callback";O:16:"Opis\Closure\Box":2:{i:0;i:1;i:1;a:4:{s:4:"info";R:20;s:4:"this";r:3;s:5:"scope";s:28:"Bytic\Scheduler\Events\Event";s:4:"vars";a:2:{s:11:"destination";s:12:"healthchecks";s:7:"options";a:1:{s:7:"trigger";s:7:"success";}}}}}}}}s:7:"command";s:6:"php -v";s:10:"expression";s:9:"* * * * *";s:6:"driver";s:8:"internal";s:10:"identifier";N;s:11:"description";N;s:6:"output";s:9:"/dev/null";s:12:"outputStream";N;s:11:"wholeOutput";a:0:{}s:4:"user";N;s:3:"cwd";N;s:7:"process";N;s:15:"inSerialization";b:1;}}}}i:1;r:17;}";}s:14:"afterCallbacks";a:2:{i:0;s:2409:"O:28:"Opis\Closure\PriorityWrapper":2:{i:0;a:1:{i:0;O:16:"Opis\Closure\Box":2:{i:0;i:3;i:1;a:2:{i:0;s:28:"Bytic\Scheduler\Events\Event";i:1;a:15:{s:7:"pingers";a:1:{s:12:"healthchecks";a:3:{i:0;a:1:{s:7:"trigger";s:6:"before";}i:1;a:1:{s:7:"trigger";s:5:"after";}i:2;a:1:{s:7:"trigger";s:7:"success";}}}s:15:"beforeCallbacks";a:1:{i:0;O:16:"Opis\Closure\Box":2:{i:0;i:1;i:1;a:4:{s:4:"info";a:5:{s:3:"key";s:32:"7ed9d0cc7ac7801a5fce084c67871bba";s:6:"header";s:111:"namespace Bytic\Scheduler\Events\Traits;
use Bytic\Scheduler\Pinger\PingerManager,
Nip\Container\Container;";s:4:"body";s:234:"function () use ($destination, $options) {
            /** @var PingerManager $manager */
$manager = Container::getInstance()->get(PingerManager::class);
            $manager::ping($destination, $this, $options);
}";s:3:"use";a:2:{i:0;s:11:"destination";i:1;s:7:"options";}s:5:"flags";i:4;}s:4:"this";r:3;s:5:"scope";s:28:"Bytic\Scheduler\Events\Event";s:4:"vars";a:2:{s:11:"destination";s:12:"healthchecks";s:7:"options";a:1:{s:7:"trigger";s:6:"before";}}}}}s:14:"afterCallbacks";a:2:{i:0;O:16:"Opis\Closure\Box":2:{i:0;i:1;i:1;a:4:{s:4:"info";R:20;s:4:"this";r:3;s:5:"scope";s:28:"Bytic\Scheduler\Events\Event";s:4:"vars";a:2:{s:11:"destination";s:12:"healthchecks";s:7:"options";a:1:{s:7:"trigger";s:5:"after";}}}}i:1;O:16:"Opis\Closure\Box":2:{i:0;i:1;i:1;a:4:{s:4:"info";a:5:{s:3:"key";s:32:"a0efdf06c6802f5b41021195a4e962ac";s:6:"header";s:76:"namespace Bytic\Scheduler\Events\Traits;
use Bytic\Scheduler\Runner\Invoker;";s:4:"body";s:178:"function ($event = null) use ($callback) {
if ($this->getProcess()->isSuccessful()) {
Invoker::call($callback, [$this], true);
}
}";s:3:"use";a:1:{i:0;s:8:"callback";}s:5:"flags";i:4;}s:4:"this";r:3;s:5:"scope";s:28:"Bytic\Scheduler\Events\Event";s:4:"vars";a:1:{s:8:"callback";O:16:"Opis\Closure\Box":2:{i:0;i:1;i:1;a:4:{s:4:"info";R:20;s:4:"this";r:3;s:5:"scope";s:28:"Bytic\Scheduler\Events\Event";s:4:"vars";a:2:{s:11:"destination";s:12:"healthchecks";s:7:"options";a:1:{s:7:"trigger";s:7:"success";}}}}}}}}s:7:"command";s:6:"php -v";s:10:"expression";s:9:"* * * * *";s:6:"driver";s:8:"internal";s:10:"identifier";N;s:11:"description";N;s:6:"output";s:9:"/dev/null";s:12:"outputStream";N;s:11:"wholeOutput";a:0:{}s:4:"user";N;s:3:"cwd";N;s:7:"process";N;s:15:"inSerialization";b:1;}}}}i:1;r:35;}";i:1;s:2409:"O:28:"Opis\Closure\PriorityWrapper":2:{i:0;a:1:{i:0;O:16:"Opis\Closure\Box":2:{i:0;i:3;i:1;a:2:{i:0;s:28:"Bytic\Scheduler\Events\Event";i:1;a:15:{s:7:"pingers";a:1:{s:12:"healthchecks";a:3:{i:0;a:1:{s:7:"trigger";s:6:"before";}i:1;a:1:{s:7:"trigger";s:5:"after";}i:2;a:1:{s:7:"trigger";s:7:"success";}}}s:15:"beforeCallbacks";a:1:{i:0;O:16:"Opis\Closure\Box":2:{i:0;i:1;i:1;a:4:{s:4:"info";a:5:{s:3:"key";s:32:"7ed9d0cc7ac7801a5fce084c67871bba";s:6:"header";s:111:"namespace Bytic\Scheduler\Events\Traits;
use Bytic\Scheduler\Pinger\PingerManager,
Nip\Container\Container;";s:4:"body";s:234:"function () use ($destination, $options) {
            /** @var PingerManager $manager */
$manager = Container::getInstance()->get(PingerManager::class);
            $manager::ping($destination, $this, $options);
}";s:3:"use";a:2:{i:0;s:11:"destination";i:1;s:7:"options";}s:5:"flags";i:4;}s:4:"this";r:3;s:5:"scope";s:28:"Bytic\Scheduler\Events\Event";s:4:"vars";a:2:{s:11:"destination";s:12:"healthchecks";s:7:"options";a:1:{s:7:"trigger";s:6:"before";}}}}}s:14:"afterCallbacks";a:2:{i:0;O:16:"Opis\Closure\Box":2:{i:0;i:1;i:1;a:4:{s:4:"info";R:20;s:4:"this";r:3;s:5:"scope";s:28:"Bytic\Scheduler\Events\Event";s:4:"vars";a:2:{s:11:"destination";s:12:"healthchecks";s:7:"options";a:1:{s:7:"trigger";s:5:"after";}}}}i:1;O:16:"Opis\Closure\Box":2:{i:0;i:1;i:1;a:4:{s:4:"info";a:5:{s:3:"key";s:32:"a0efdf06c6802f5b41021195a4e962ac";s:6:"header";s:76:"namespace Bytic\Scheduler\Events\Traits;
use Bytic\Scheduler\Runner\Invoker;";s:4:"body";s:178:"function ($event = null) use ($callback) {
            if ($this->getProcess()->isSuccessful()) {
Invoker::call($callback, [$this], true);
            }
}";s:3:"use";a:1:{i:0;s:8:"callback";}s:5:"flags";i:4;}s:4:"this";r:3;s:5:"scope";s:28:"Bytic\Scheduler\Events\Event";s:4:"vars";a:1:{s:8:"callback";O:16:"Opis\Closure\Box":2:{i:0;i:1;i:1;a:4:{s:4:"info";R:20;s:4:"this";r:3;s:5:"scope";s:28:"Bytic\Scheduler\Events\Event";s:4:"vars";a:2:{s:11:"destination";s:12:"healthchecks";s:7:"options";a:1:{s:7:"trigger";s:7:"success";}}}}}}}}s:7:"command";s:6:"php -v";s:10:"expression";s:9:"* * * * *";s:6:"driver";s:8:"internal";s:10:"identifier";N;s:11:"description";N;s:6:"output";s:9:"/dev/null";s:12:"outputStream";N;s:11:"wholeOutput";a:0:{}s:4:"user";N;s:3:"cwd";N;s:7:"process";N;s:15:"inSerialization";b:1;}}}}i:1;r:44;}";}s:7:"command";s:6:"php -v";s:10:"expression";s:9:"* * * * *";s:6:"driver";s:8:"internal";s:10:"identifier";N;s:11:"description";N;s:6:"output";s:9:"/dev/null";s:12:"outputStream";N;s:11:"wholeOutput";a:0:{}s:4:"user";N;s:3:"cwd";N;s:7:"process";N;s:15:"inSerialization";b:0;}