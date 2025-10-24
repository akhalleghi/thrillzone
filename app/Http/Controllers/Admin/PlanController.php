<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Plan;
use Illuminate\Http\Request;

class PlanController extends Controller
{
    public function index()
    {
        $plans = Plan::latest()->paginate(12);
        return view('admin.plans', compact('plans'));
    }

    public function store(Request $request)
    {
        $data = $this->validatedData($request);

        // durations & prices ساخت Map قیمت‌ها
        [$durations, $prices] = $this->buildDurationsAndPrices($request);
        $data['durations'] = $durations;
        $data['prices']    = $prices;

        Plan::create($data);

        return back()->with('success', 'پلن با موفقیت ایجاد شد.');
    }

    public function update(Request $request, Plan $plan)
    {
        $data = $this->validatedData($request);

        [$durations, $prices] = $this->buildDurationsAndPrices($request);
        $data['durations'] = $durations;
        $data['prices']    = $prices;

        $plan->update($data);

        return back()->with('success', 'پلن با موفقیت ویرایش شد.');
    }

    public function destroy(Plan $plan)
    {
        $plan->delete();
        return back()->with('success', 'پلن حذف شد.');
    }

    // ---------------- helpers ----------------
    private function validatedData(Request $request): array
    {
        $request->validate([
            'name'               => ['required','string','max:150'],
            'platforms'          => ['nullable','array'],              // ["ps4","ps5"]
            'capability'         => ['required','in:online,offline,both'],
            'concurrent_games'   => ['required','integer','between:1,30'],
            'all_ps_store'       => ['nullable','boolean'],
            'level1_selection'   => ['required','integer','between:1,30'],
            'swap_limit'         => ['required','in:10d,15d,1m,2m'],
            'install_options'    => ['nullable','array'],              // ["online","inperson"]
            'game_type'          => ['nullable','string','max:150'],
            'has_discount'       => ['nullable','boolean'],
            'discount_percent'   => ['nullable','integer','between:0,100'],
            'has_free_games'     => ['nullable','boolean'],
            'free_games_count'   => ['nullable','integer','between:1,30'],
            'description'        => ['nullable','string'],
            'active'             => ['nullable','boolean'],

            // durations & prices → در build چک نهایی می‌کنیم
            'dur_3'              => ['nullable','boolean'],
            'dur_6'              => ['nullable','boolean'],
            'dur_12'             => ['nullable','boolean'],
            'price_3'            => ['nullable','integer','min:0'],
            'price_6'            => ['nullable','integer','min:0'],
            'price_12'           => ['nullable','integer','min:0'],
        ],[
            'name.required' => 'نام پلن را وارد کنید',
            'capability.in' => 'گزینه‌ی قابلیت اجرا معتبر نیست',
            'swap_limit.in' => 'گزینه‌ی محدودیت تعویض معتبر نیست',
        ]);

        return [
            'name'             => $request->input('name'),
            'platforms'        => $request->input('platforms', []),
            'capability'       => $request->input('capability'),
            'concurrent_games' => (int)$request->input('concurrent_games', 1),
            'all_ps_store'     => (bool)$request->boolean('all_ps_store'),
            'level1_selection' => (int)$request->input('level1_selection', 1),
            'swap_limit'       => $request->input('swap_limit'),
            'install_options'  => $request->input('install_options', []),
            'game_type'        => $request->input('game_type'),
            'has_discount'     => (bool)$request->boolean('has_discount'),
            'discount_percent' => $request->filled('has_discount') ? (int)$request->input('discount_percent', 0) : null,
            'has_free_games'   => (bool)$request->boolean('has_free_games'),
            'free_games_count' => $request->filled('has_free_games') ? (int)$request->input('free_games_count', 0) : null,
            'description'      => $request->input('description'),
            'active'           => (bool)$request->boolean('active', true),
        ];
    }

    private function buildDurationsAndPrices(Request $request): array
    {
        $durations = [];
        $prices    = [];

        if ($request->boolean('dur_3')) {
            $durations[] = 3;
            $prices['3'] = (int)$request->input('price_3', 0);
        }
        if ($request->boolean('dur_6')) {
            $durations[] = 6;
            $prices['6'] = (int)$request->input('price_6', 0);
        }
        if ($request->boolean('dur_12')) {
            $durations[] = 12;
            $prices['12'] = (int)$request->input('price_12', 0);
        }

        // حداقل یکی از مدت‌ها انتخاب شود
        if (empty($durations)) {
            abort(422, 'حداقل یکی از مدت‌های اشتراک (۳/۶/۱۲ ماهه) را انتخاب کنید.');
        }

        return [$durations, $prices];
    }
}
