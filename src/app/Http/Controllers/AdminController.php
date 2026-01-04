<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Contact;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\StreamedResponse;

class AdminController extends Controller
{
    public function index()
    {
        $categories = Category::all();
        $contacts = Contact::orderByDesc('created_at')->paginate(7);

        return view('admin', compact('categories', 'contacts'));
    }

    public function search(Request $request)
{
    $categories = Category::all();
    $query = Contact::query()->orderByDesc('created_at');

    // keyword（名前 or メール）
    $keyword = trim((string)$request->input('keyword', ''));
    if ($keyword !== '') {
        $query->where(function ($q) use ($keyword) {
            $q->where('email', 'like', "%{$keyword}%")
                ->orWhere('first_name', 'like', "%{$keyword}%")
                ->orWhere('last_name', 'like', "%{$keyword}%")
                ->orWhereRaw("CONCAT(last_name, ' ', first_name) LIKE ?", ["%{$keyword}%"])
                ->orWhereRaw("CONCAT(last_name, first_name) LIKE ?", ["%{$keyword}%"]);
        });
    }

    // gender（'' は未指定 / all は絞り込みなし）
    $gender = (string)$request->input('gender', '');
    if ($gender !== '' && $gender !== 'all') {
        $query->where('gender', (int)$gender);
    }

    // category_id
    $categoryId = (string)$request->input('category_id', '');
    if ($categoryId !== '') {
        $query->where('category_id', (int)$categoryId);
    }

    // date（空なら絞り込まない）
    $date = (string)$request->input('date', '');
    if ($date !== '') {
        $query->whereDate('created_at', $date);
    }

    $contacts = $query->paginate(7)->appends($request->query());

    return view('admin', compact('categories', 'contacts'));
}

    public function reset()
    {
        return redirect('/admin');
    }

    public function export(Request $request)
{
    $query = Contact::query()->orderByDesc('created_at');

    $keyword = trim((string)$request->input('keyword', ''));
    if ($keyword !== '') {
        $query->where(function ($q) use ($keyword) {
            $q->where('email', 'like', "%{$keyword}%")
              ->orWhere('first_name', 'like', "%{$keyword}%")
              ->orWhere('last_name', 'like', "%{$keyword}%")
              ->orWhereRaw("CONCAT(last_name, ' ', first_name) LIKE ?", ["%{$keyword}%"])
              ->orWhereRaw("CONCAT(last_name, first_name) LIKE ?", ["%{$keyword}%"]);
        });
    }

    $gender = (string)$request->input('gender', '');
    if ($gender !== '' && $gender !== 'all') {
        $query->where('gender', (int)$gender);
    }

    $categoryId = (string)$request->input('category_id', '');
    if ($categoryId !== '') {
        $query->where('category_id', (int)$categoryId);
    }

    $date = (string)$request->input('date', '');
    if ($date !== '') {
        $query->whereDate('created_at', $date);
    }

    $contacts = $query->with('category')->get();

    $headers = [
        'Content-Type' => 'text/csv; charset=UTF-8',
        'Content-Disposition' => 'attachment; filename="contacts.csv"',
    ];

    $callback = function () use ($contacts) {
        $out = fopen('php://output', 'w');

        // Excelで文字化けしにくいようにBOM
        fwrite($out, "\xEF\xBB\xBF");

        // ヘッダー行（必要に応じて変更OK）
        fputcsv($out, [
            'ID', 'お名前', '性別', 'メール', '電話', '住所', '建物名', 'お問い合わせ種類', 'お問い合わせ内容', '作成日'
        ]);

        foreach ($contacts as $c) {
            $genderLabel = $c->gender === 1 ? '男性' : ($c->gender === 2 ? '女性' : 'その他');

            fputcsv($out, [
                $c->id,
                $c->last_name . ' ' . $c->first_name,
                $genderLabel,
                $c->email,
                $c->tel,
                $c->address,
                $c->building,
                optional($c->category)->content,
                $c->detail,
                $c->created_at,
            ]);
        }

        fclose($out);
    };

    return response()->stream($callback, 200, $headers);
}

    public function destroy(Request $request, Contact $contact)
    {
        $contact->delete();

        $redirect = $request->input('redirect', '/admin');

        // 外部URLへ飛ばないようにガード（先頭が / のみ許可、// は拒否）
        if (!is_string($redirect) || strpos($redirect, '/') !== 0 || strpos($redirect, '//') === 0) {
        $redirect = '/admin';
        }

    return redirect($redirect);
    }
}
