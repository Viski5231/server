<?php

namespace Controller;

use Illuminate\Database\Capsule\Manager as Capsule;
use Model\Division;
use Model\Phone;
use Model\Premise;
use Model\Subscriber;
use Src\Request;
use Src\View;
use Src\Validator\Validator;

class TelephonyController
{
    public function index(Request $request): string
    {
        $totalSubscribers = Subscriber::query()->count();
        $totalPhones = Phone::query()->count();
        $totalDivisions = Division::query()->count();
        $totalPremises = Premise::query()->count();

        return (new View())->render('telephony.dashboard', [
            'totalSubscribers' => $totalSubscribers,
            'totalPhones' => $totalPhones,
            'totalDivisions' => $totalDivisions,
            'totalPremises' => $totalPremises,
        ]);
    }

    public function divisions(Request $request): string
    {
        if ($request->method === 'POST') {
            $validator = new Validator($request->all(), [
                'name' => ['required'],
                'type' => ['required'],
            ], [
                'required' => 'Поле :field обязательно для заполнения',
            ]);

            if ($validator->fails()) {
                return (new View())->render('telephony.divisions', [
                    'message' => json_encode($validator->errors(), JSON_UNESCAPED_UNICODE),
                    'divisions' => Division::orderBy('name')->get(),
                ]);
            }

            Division::create([
                'name' => $request->get('name'),
                'type' => $request->get('type'),
            ]);

            app()->route->redirect('/divisions?success=1');
        }

        return (new View())->render('telephony.divisions', [
            'success' => $request->get('success'),
            'divisions' => Division::orderBy('name')->get(),
        ]);
    }

    public function premises(Request $request): string
    {
        $divisions = Division::orderBy('name')->get();

        if ($request->method === 'POST') {
            $validator = new Validator($request->all(), [
                'name' => ['required'],
                'type' => ['required'],
                'division_id' => ['required'],
            ], [
                'required' => 'Поле :field обязательно для заполнения',
            ]);

            if ($validator->fails()) {
                return (new View())->render('telephony.premises', [
                    'message' => json_encode($validator->errors(), JSON_UNESCAPED_UNICODE),
                    'divisions' => $divisions,
                    'premises' => Premise::with('division')->orderBy('id', 'desc')->get(),
                ]);
            }

            Premise::create([
                'name' => $request->get('name'),
                'type' => $request->get('type'),
                'division_id' => (int)$request->get('division_id'),
            ]);

            app()->route->redirect('/premises?success=1');
        }

        return (new View())->render('telephony.premises', [
            'success' => $request->get('success'),
            'divisions' => $divisions,
            'premises' => Premise::with('division')->orderBy('id', 'desc')->get(),
        ]);
    }

    public function phones(Request $request): string
    {
        $premises = Premise::with('division')->orderBy('id', 'desc')->get();

        if ($request->method === 'POST') {
            $validator = new Validator($request->all(), [
                'number' => ['required'],
                'premise_id' => ['required'],
            ], [
                'required' => 'Поле :field обязательно для заполнения',
            ]);

            if ($validator->fails()) {
                return (new View())->render('telephony.phones', [
                    'message' => json_encode($validator->errors(), JSON_UNESCAPED_UNICODE),
                    'premises' => $premises,
                    'phones' => Phone::with('premise.division')->orderBy('id', 'desc')->get(),
                ]);
            }

            Phone::create([
                'number' => $request->get('number'),
                'premise_id' => (int)$request->get('premise_id'),
            ]);

            app()->route->redirect('/phones?success=1');
        }

        return (new View())->render('telephony.phones', [
            'success' => $request->get('success'),
            'premises' => $premises,
            'phones' => Phone::with('premise.division')->orderBy('id', 'desc')->get(),
        ]);
    }

    public function subscribers(Request $request): string
    {
        $divisions = Division::orderBy('name')->get();

        if ($request->method === 'POST') {
            $validator = new Validator($request->all(), [
                'lastname' => ['required'],
                'firstname' => ['required'],
                'patronymic' => ['required'],
                'birthdate' => ['required'],
                'division_id' => ['required'],
            ], [
                'required' => 'Поле :field обязательно для заполнения',
            ]);

            if ($validator->fails()) {
                return (new View())->render('telephony.subscribers', [
                    'message' => json_encode($validator->errors(), JSON_UNESCAPED_UNICODE),
                    'divisions' => $divisions,
                    'subscribers' => Subscriber::with('division')->orderBy('id', 'desc')->get(),
                ]);
            }

            Subscriber::create([
                'lastname' => $request->get('lastname'),
                'firstname' => $request->get('firstname'),
                'patronymic' => $request->get('patronymic'),
                'birthdate' => $request->get('birthdate'),
                'division_id' => (int)$request->get('division_id'),
            ]);

            app()->route->redirect('/subscribers?success=1');
        }

        return (new View())->render('telephony.subscribers', [
            'success' => $request->get('success'),
            'divisions' => $divisions,
            'subscribers' => Subscriber::with('division')->orderBy('id', 'desc')->get(),
        ]);
    }

    public function assignPhone(Request $request): string
    {
        $subscribers = Subscriber::with('division')->orderBy('lastname')->get();
        $phones = Phone::with('premise.division')->orderBy('number')->get();

        if ($request->method === 'POST') {
            $subscriberId = (int)$request->get('subscriber_id');
            $phoneId = (int)$request->get('phone_id');

            if ($subscriberId && $phoneId) {
                // One phone -> only one subscriber. Reassign by clearing previous links.
                Capsule::table('subscriber_phone')->where('phone_id', $phoneId)->delete();
                Capsule::table('subscriber_phone')->insert([
                    'subscriber_id' => $subscriberId,
                    'phone_id' => $phoneId,
                    'assigned_at' => date('Y-m-d H:i:s'),
                    'created_at' => date('Y-m-d H:i:s'),
                    'updated_at' => date('Y-m-d H:i:s'),
                ]);

                app()->route->redirect('/assign-phone?success=1');
            }
        }

        $assignments = Capsule::table('subscriber_phone')
            ->join('subscribers', 'subscribers.id', '=', 'subscriber_phone.subscriber_id')
            ->join('phones', 'phones.id', '=', 'subscriber_phone.phone_id')
            ->leftJoin('premises', 'premises.id', '=', 'phones.premise_id')
            ->leftJoin('divisions', 'divisions.id', '=', 'subscribers.division_id')
            ->select([
                'subscriber_phone.assigned_at',
                'subscribers.id as subscriber_id',
                'subscribers.lastname',
                'subscribers.firstname',
                'subscribers.patronymic',
                'divisions.name as division_name',
                'phones.id as phone_id',
                'phones.number',
                'premises.name as premise_name',
                'premises.type as premise_type',
            ])
            ->orderBy('subscriber_phone.assigned_at', 'desc')
            ->get();

        return (new View())->render('telephony.assign-phone', [
            'success' => $request->get('success'),
            'subscribers' => $subscribers,
            'phones' => $phones,
            'assignments' => $assignments,
        ]);
    }

    public function reports(Request $request): string
    {
        $divisionId = (int)$request->get('division_id');
        $subscriberId = (int)$request->get('subscriber_id');

        $divisions = Division::orderBy('name')->get();
        $subscribers = Subscriber::orderBy('lastname')->get();

        // Subscriber numbers by division
        $numbersByDivision = [];
        if ($divisionId) {
            $numbersByDivision = Capsule::table('subscribers')
                ->leftJoin('subscriber_phone', 'subscriber_phone.subscriber_id', '=', 'subscribers.id')
                ->leftJoin('phones', 'phones.id', '=', 'subscriber_phone.phone_id')
                ->where('subscribers.division_id', $divisionId)
                ->orderBy('subscribers.lastname')
                ->select([
                    'subscribers.lastname',
                    'subscribers.firstname',
                    'subscribers.patronymic',
                    'phones.number',
                ])
                ->get();
        }

        // All numbers of a subscriber
        $numbersOfSubscriber = [];
        if ($subscriberId) {
            $numbersOfSubscriber = Capsule::table('subscribers')
                ->leftJoin('subscriber_phone', 'subscriber_phone.subscriber_id', '=', 'subscribers.id')
                ->leftJoin('phones', 'phones.id', '=', 'subscriber_phone.phone_id')
                ->leftJoin('premises', 'premises.id', '=', 'phones.premise_id')
                ->where('subscribers.id', $subscriberId)
                ->orderBy('phones.number')
                ->select([
                    'phones.number',
                    'premises.name as premise_name',
                    'premises.type as premise_type',
                ])
                ->get();
        }

        // Counts by division (subscribers.division_id)
        $countByDivision = Capsule::table('divisions')
            ->leftJoin('subscribers', 'subscribers.division_id', '=', 'divisions.id')
            ->groupBy('divisions.id', 'divisions.name', 'divisions.type')
            ->orderBy('divisions.name')
            ->select([
                'divisions.name',
                'divisions.type',
                Capsule::raw('COUNT(subscribers.id) as subscribers_count'),
            ])
            ->get();

        // Counts by premise (count unique subscribers having phones in premise)
        $countByPremise = Capsule::table('premises')
            ->leftJoin('phones', 'phones.premise_id', '=', 'premises.id')
            ->leftJoin('subscriber_phone', 'subscriber_phone.phone_id', '=', 'phones.id')
            ->groupBy('premises.id', 'premises.name', 'premises.type')
            ->orderBy('premises.name')
            ->select([
                'premises.name',
                'premises.type',
                Capsule::raw('COUNT(DISTINCT subscriber_phone.subscriber_id) as subscribers_count'),
            ])
            ->get();

        return (new View())->render('telephony.reports', [
            'divisions' => $divisions,
            'subscribers' => $subscribers,
            'divisionId' => $divisionId ?: null,
            'subscriberId' => $subscriberId ?: null,
            'numbersByDivision' => $numbersByDivision,
            'numbersOfSubscriber' => $numbersOfSubscriber,
            'countByDivision' => $countByDivision,
            'countByPremise' => $countByPremise,
        ]);
    }
}

