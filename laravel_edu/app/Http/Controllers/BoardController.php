<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class BoardController extends Controller
{
    public function index()
    {
        // ---------------------
        // 쿼리 빌더
        // ---------------------
        $result = DB::select('select * from boards limit 10');

        $result = DB::select('select * from boards limit :no offset :no2', ['no' => 2, 'no2' => 10]);
        $result = DB::select('select * from boards limit ? offset ?', [2, 10]);

        // 카테고리가 4, 7, 8 인 게시글의 수를 출력해 주세요.
        $arr = [4, 7, 8];
        $result = DB::select(
            'select count(id) 
            from boards 
            where categories_no = ?
            or categories_no = ?
            or categories_no =?',
            $arr
        );

        // 카테고리별 게시글 갯수를 출력해주세요.
        $result = DB::select(
            'SELECT
            ca.no
            ,ca.name
            ,COUNT(bo.id) AS cnt
            FROM boards bo
            JOIN categories ca ON bo.categories_no = ca.no
            GROUP BY ca.no, ca.name'
        );

        // ------------insert-----------------
        $sql =
            'INSERT INTO boards(
                title
                , content
                , created_at
                , updated_at
                , categories_no
            )
            VALUES
                (?, ?, ?, ?, ?)';
        $arr = [
            '제목1',
            '내용내용1',
            now(),
            now(),
            '0'
        ];
        // DB::insert($sql, $arr);
        // DB::beginTransaction();
        // DB::commit();

        $result = DB::select('SELECT * FROM boards ORDER BY id DESC LIMIT 1');

        // ----------- update ------------
        // DB::beginTransaction();
        // DB::update('UPDATE boards SET title = ?, content = ? WHERE id = ?'
        // ,['업데이트1', '업업', $result[0]->id]
        // );

        // DB::commit();

        // ---------- delete ---------------
        DB::beginTransaction();
        DB::delete('DELETE FROM boards WHERE id = ?', [$result[0]->id]);
        DB::commit();

        // ----------
        // 쿼리 빌더 체이닝
        // ----------
        // select * from boards where id = 300;
        $result = 
        DB::table('boards')
        ->where('id', '=', 300)
        ->get();

        // select * from boards where id = 300 or id = 400;
        $result = 
        DB::table('boards')
        ->where('id', '=', 300)
        ->orWhere('id', '=', 400)
        ->get();

        // select * from categories where no in (?, ?, ?);

        $result=
        DB::table('categories')
        ->whereIn('no', [1, 2, 3])
        ->get();

        // select * from categories where no not in (?, ?, ?)
        $result=
        DB::table('categories')
        ->whereNotIn('no', [1, 2, 3])
        ->get();

        // first() : limit1하고 비슷하게 동작
        $result = DB::table('boards')->first();

        // count() : 결과의 레코드 수를 반환
        $result = DB::table('boards')->count();

        // max() : 해당 칼럼의 최대 값
        $result = DB::table('categories')->max('no');

        // 타이틀, 내용, 카테고리명 까지 출력 100개
        $result = 
        DB::table('boards')
        ->select('boards.title', 'boards.content', 'categories.name')
        ->join('categories', 'categories.no', 'boards.categories_no')
        ->limit(100)
        ->get();

        // 카테고리별 게시글 갯수를 출력해주세요.
                $result =
                DB::table('boards')
                ->select('categories.no', 'categories.name', DB::raw('count(categories.no)'))
                ->join('categories', 'categories.no','boards.categories_no')
                ->groupBy('categories.no', 'categories.name')
                ->get();

        return var_dump($result);

    }
}
