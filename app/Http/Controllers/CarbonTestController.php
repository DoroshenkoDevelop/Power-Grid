<?php

namespace App\Http\Controllers;

use App\Models\User;
use Carbon\CarbonImmutable;
use Illuminate\Http\Request;
use Carbon\Carbon;
use PhpParser\Node\Stmt\Echo_;

class CarbonTestController extends Controller
{
    public $friday;
    public $users;

    public function index()
    {
        $this->getFriday();
        $users = User::all();
        return view ('dashboard',compact('users'));
    }

    public function getFriday()
    {
        /*$friday = Carbon::now()->next(5)->toDateString();
        $carbonFriday = Carbon::create(2021,11,3,0,0,0);
        $carbonFriday = Carbon::createSafe(2021,11,3,0,0,0);// проверяется на соответствие
        $carbonFridayTime = Carbon::createFromTimestamp(1);// выдает дату по временной метке
        $carbon  = new Carbon();
        echo $carbon->format('D')."<br>";// выводим только день
        echo $carbonFriday->toDateString()."<br>";//выводит только дату
        echo $carbonFriday."<br>";
        echo $carbonFridayTime."<br>";
        echo $friday."<br>";
        echo date("jS F, Y", strtotime('friday'));*/
       /* echo (Carbon::now()->closest('thursday','saturday')); //closest возвращает ближайшую дату и с тех дат которые являются аргументом
        echo (Carbon::now()->farthest('thursday','saturday')); //closest возвращает дальнию дату и с тех дат которые являются аргументом*/
    /*    $carbonFridayNow = Carbon::now()->isTuesday();
        echo $carbonFridayNow;*/

       /* $friday = Carbon::now();

        if ($friday->is('Friday'))
        {
            echo $friday->format('Y-m-d');
        }

        if($friday->is('Monday'))
        {
            echo $friday->subDays(3)->format('Y-m-d');
        }

        if($friday->is('Tuesday'))
        {
            echo $friday->subDays(4)->format('Y-m-d');
        }

        if($friday->is('Wednesday'))
        {
            echo $friday->addDays(2)->format('Y-m-d');
        }

        if($friday->is('Thursday'))
        {
            echo $friday->addDays(1)->format('Y-m-d');
        }*/


        $friday = Carbon::now();

        switch ($friday) {
            case ($friday->is('Friday')):
                echo $friday->format('Y-m-d');
                break;

            case ($friday->is('Monday')):
                echo $friday->subDays(3)->format('Y-m-d');
                break;

            case ($friday->is('Tuesday')):
                echo $friday->subDays(4)->format('Y-m-d');
                break;

            case ($friday->is('Wednesday')):
                echo $friday->addDays(2)->format('Y-m-d');
                break;

            case ($friday->is('Thursday')):
                echo $friday->addDays(1)->format('Y-m-d');
                break;

            case ($friday->is('Saturday')):
                echo $friday->subDays(1)->format('Y-m-d');
                break;

                case ($friday->is('Sunday')):
                    echo $friday->subDays(2)->format('Y-m-d');
                break;
    }
}
}
