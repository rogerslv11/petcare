<?php

use App\Jobs\CheckVaccinesDue;
use App\Jobs\ProcessSubscriptions;
use App\Jobs\SendAppointmentReminder;
use Illuminate\Support\Facades\Schedule;

Schedule::job(new SendAppointmentReminder)->dailyAt('18:00');
Schedule::job(new CheckVaccinesDue)->dailyAt('08:00');
Schedule::job(new ProcessSubscriptions)->daily();
