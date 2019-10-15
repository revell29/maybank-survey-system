<?php

namespace App\Http\Controllers\Report;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\ResultBranch;
use App\Models\UserBranch;
use App\Models\Branches;
use App\Models\SurveiResult;
use Auth;
use App;
use PDF;
use DB;
use DataTables;
use Carbon\Carbon;
use Entrust;

class ReportController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('backend.report.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request, $id)
    { }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }

    public function data(Request $request)
    {
        $data = \App\Models\Branches::query();

        if ($request->has('datefrom') && $request->datefrom != null) {
            $date = explode(' - ', $request->input('datefrom'));
            $dd1 = $date[0] . '00:00';
            $dd2 = $date[1] . '23:59';
            $date_1 = Carbon::parse($dd1)->format('Y-m-d H:i');
            $date_2 = Carbon::parse($dd2)->format('Y-m-d H:i');
            $data = $data->with(['survey_branch' => function ($q) use ($date_1, $date_2) {
                $q->whereBetween('created_at', [$date_1, $date_2])
                    ->select(
                        'branch_id',
                        DB::raw('SUM(level_1) as lv1'),
                        DB::raw('SUM(level_2) as lv2'),
                        DB::raw('SUM(level_3) as lv3'),
                        DB::raw('COUNT(level_1)+COUNT(level_2)+COUNT(level_3) as total')
                    )
                    ->whereNotNull('branch_id')
                    ->groupBy('branch_id');
            }])->whereHas('survey_branch', function ($f) {
                $f->whereNotNull('branch_id');
            })->get();
        } else {
            $data = $data->with(['survey_branch' => function ($q) {
                $q->select(
                    'branch_id',
                    DB::raw('SUM(level_1) as lv1'),
                    DB::raw('SUM(level_2) as lv2'),
                    DB::raw('SUM(level_3) as lv3'),
                    DB::raw('COUNT(level_1)+COUNT(level_2)+COUNT(level_3) as total')
                )
                    ->whereNotNull('branch_id')
                    ->whereDate('created_at', Carbon::now())->whereNotNull('branch_id')
                    ->groupBy('branch_id');
            }])->whereHas('survey_branch', function ($f) {
                $f->whereNotNull('branch_id');
            })->get();
        }


        return DataTables::of($data)
            ->addColumn('total', function ($item) {
                if ($item->survey_branch) {
                    return $item->survey_branch->map(function ($q) {
                        return $q->total;
                    })->implode('<br>');
                } else {
                    return 0;
                }
            })
            ->addColumn('puas', function ($item) {
                if ($item->survey_branch) {
                    return $item->survey_branch->map(function ($q) {
                        return $q->lv3;
                    })->implode('<br>');
                } else {
                    return 0;
                }
            })
            ->addColumn('biasa', function ($item) {
                if ($item->survey_branch()->first()) {
                    return $item->survey_branch->map(function ($q) {
                        return $q->lv2;
                    })->implode('<br>');
                } else {
                    return 0;
                }
            })
            ->addColumn('tidak_puas', function ($item) {
                if ($item->survey_branch()->first()) {
                    return $item->survey_branch->map(function ($q) {
                        return $q->lv1;
                    })->implode('<br>');
                } else {
                    return 0;
                }
            })
            ->editColumn('branch_name', function ($q) {
                return '<a href="' . route('Report::detail', $q->id) . '">' . $q->branch_name . '</a>';
            })
            ->escapeColumns([])
            ->make(true);
    }

    public function detail(Request $request, $id)
    {
        $data = SurveiResult::where('branch_id', $id)->first();
        if ($data) {
            return view('backend.report.detail', compact('data'));
        }
        abort(404);
    }

    public function detailList(Request $request)
    {
        $id = $request->input('branch_id');
        $data = SurveiResult::query()->with('branch')->where('branch_id', $id);

        if ($request->has('datefrom') && $request->datefrom != null) {
            $date = explode(' - ', $request->input('datefrom'));
            $dd1 = $date[0] . '0:00';
            $dd2 = $date[1] . '23:59';
            $date_1 = Carbon::parse($dd1)->format('Y-m-d H:i');
            $date_2 = Carbon::parse($dd2)->format('Y-m-d H:i');
            $data = $data->whereBetween('created_at', [$date_1, $date_2])->orderBy('created_at', 'DESC')->get();
        } else {
            $data = $data->whereDate('created_at', Carbon::now())->orderBy('created_at', 'DESC')->get();
        }

        return DataTables::of($data)
            ->addColumn('total', function ($item) {
                $total = $item->level_1 + $item->level_2 + $item->level_3;
                return $total;
            })
            ->addColumn('date', function ($item) {
                return $item->created_at->format('d F Y');
            })
            ->addColumn('time', function ($item) {
                return $item->created_at->format('H:i:s');
            })
            ->escapeColumns([])
            ->make(true);
    }

    public function export(Request $request)
    {
        $data = [];
        $export = SurveiResult::with('branch')->select(
            'branch_id',
            DB::raw('COUNT(level_1) as level1'),
            DB::raw('COUNT(level_2) as level2'),
            DB::raw('COUNT(level_3) as level3')
        )
            ->groupBy('branch_id')->get();
        foreach ($export as $s) {
            array_push($data, [
                'Branch Code' => $s->branch->branch_id,
                'Branch Name' => $s->branch->branch_name,
                'Tidak Puas' => $s->level1,
                'Biasa' => $s->level2,
                'Puas' => $s->level3,
                'total' => $s->level1 + $s->level2 + $s->level3
            ]);
        }

        $excel = \Excel::create('Report Feedback - ' . date('d F Y'), function ($excel) use ($data) {
            $excel->setTitle('Report Feedback - ' . date('d F Y'));
            $excel->setCreator(Auth::user()->username)->setCompany('Maybank');

            $excel->sheet('Feebeack', function ($sheet) use ($data) {
                $sheet->fromArray($data, null, 'A1', false, true);
                $sheet->freezeFirstRow();

                $sheet->cells('A1:F1', function ($cells) {
                    $cells->setBackground('#95b3d7');
                    $cells->setFont([
                        'family' => 'Calibri',
                        'size' => '11',
                        'bold' => true
                    ]);
                    $cells->setBorder('solid', 'solid', 'solid', 'solid');
                    $cells->setValignment('center');
                });
            });
        });

        $excel->export('xlsx');
        \LogActivity::addToLog(Auth::user()->username . ' exporting report (excel)');
    }

    private function exportDetail($branch, $from)
    {
        $id = $branch;
        $data1 = [];
        $data = SurveiResult::query()->with('branch')->where('branch_id', $id);

        if ($from) {
            $date = explode(' - ', $from);
            $dd1 = $date[0] . '00:00';
            $dd2 = $date[1] . '23:59';
            $date_1 = Carbon::parse($dd1)->format('Y-m-d H:i');
            $date_2 = Carbon::parse($dd2)->format('Y-m-d H:i');
            $data = $data->whereBetween('created_at', [$date_1, $date_2])->orderBy('created_at', 'DESC')->get();
        } else {
            $data = $data->whereDate('created_at', Carbon::now())->orderBy('created_at', 'DESC')->get();
        }

        foreach ($data as $s) {
            array_push($data1, [
                'Date' => $s->created_at->format('d F Y'),
                'Time' => $s->created_at->format('H:i'),
                'Tidak Puas' => $s->level_1,
                'Biasa' => $s->level_2,
                'Puas' => $s->level_3,
            ]);
        }

        $excel = \Excel::create('Report Feedback - ' . date('d F Y'), function ($excel) use ($data1) {
            $excel->setTitle('Report Feedback - ' . date('d F Y'));
            $excel->setCreator(Auth::user()->username)->setCompany('Maybank');

            $excel->sheet('Feebeack', function ($sheet) use ($data1) {
                $sheet->fromArray($data1, null, 'A1', false, true);
                $sheet->freezeFirstRow();

                $sheet->cells('A1:E1', function ($cells) {
                    $cells->setBackground('#95b3d7');
                    $cells->setFont([
                        'family' => 'Calibri',
                        'size' => '11',
                        'bold' => true
                    ]);
                    $cells->setBorder('solid', 'solid', 'solid', 'solid');
                    $cells->setValignment('center');
                });
            });
        });

        $excel->export('xlsx');
        \LogActivity::addToLog(Auth::user()->username . ' exporting report (excel)');
    }

    /**
     *  Export Excel Index
     */
    private function exportDetailIndex($from)
    {
        $data = \App\Models\Branches::query();

        if ($from) {
            $date = explode(' - ', $from);
            $dd1 = $date[0] . '00:00';
            $dd2 = $date[1] . '23:59';
            $date_1 = Carbon::parse($dd1)->format('Y-m-d H:i');
            $date_2 = Carbon::parse($dd2)->format('Y-m-d H:i');
            $data = $data->with(['survey_branch' => function ($q) use ($date_1, $date_2) {
                $q->whereBetween('created_at', [$date_1, $date_2])
                    ->select(
                        'branch_id',
                        DB::raw('SUM(level_1) as lv1'),
                        DB::raw('SUM(level_2) as lv2'),
                        DB::raw('SUM(level_3) as lv3'),
                        DB::raw('COUNT(level_1)+COUNT(level_2)+COUNT(level_3) as total')
                    )
                    ->whereNotNull('branch_id')
                    ->groupBy('branch_id');
            }])->whereHas('survey_branch', function ($f) {
                $f->whereNotNull('branch_id');
            })->orderBy('created_at', 'DESC')->get();
        } else {
            $data = $data->with(['survey_branch' => function ($q) {
                $q->select(
                    'branch_id',
                    DB::raw('SUM(level_1) as lv1'),
                    DB::raw('SUM(level_2) as lv2'),
                    DB::raw('SUM(level_3) as lv3'),
                    DB::raw('COUNT(level_1)+COUNT(level_2)+COUNT(level_3) as total')
                )
                    ->whereNotNull('branch_id')
                    ->whereDate('created_at', Carbon::now())->whereNotNull('branch_id')
                    ->groupBy('branch_id');
            }])->whereHas('survey_branch', function ($f) {
                $f->whereNotNull('branch_id');
            })->orderBy('created_at', 'DESC')->get();
        }

        $data1 = [];
        foreach ($data as $s) {
            foreach ($s->survey_branch as $d) {
                array_push($data1, [
                    'Branch ID' => $s->branch_id,
                    'Branch Name' => $s->branch_name,
                    'Tidak Puas' => $d->lv1,
                    'Biasa' => $d->lv2,
                    'Puas' => $d->lv3,
                    'Total' => $d->total
                ]);
            }
        }

        $excel = \Excel::create('Report Feedback - ' . date('d F Y'), function ($excel) use ($data1) {
            $excel->setTitle('Report Feedback - ' . date('d F Y'));
            $excel->setCreator(Auth::user()->username)->setCompany('Maybank');

            $excel->sheet('Feebeack', function ($sheet) use ($data1) {
                $sheet->fromArray($data1, null, 'A1', false, true);
                $sheet->freezeFirstRow();

                $sheet->cells('A1:F1', function ($cells) {
                    $cells->setBackground('#95b3d7');
                    $cells->setFont([
                        'family' => 'Calibri',
                        'size' => '11',
                        'bold' => true
                    ]);
                    $cells->setBorder('solid', 'solid', 'solid', 'solid');
                    $cells->setValignment('center');
                });
            });
        });

        $excel->export('xlsx');
        \LogActivity::addToLog(Auth::user()->username . ' exporting report (excel)');
    }

    public function exportSelect(Request $request)
    {
        if ($request->has('pdf')) {
            $id = $request->branch_id;
            $branch = Branches::find($id);
            $data = SurveiResult::query()->with('branch')->where('branch_id', $id);
            $date1 = $request->datefrom;

            if ($request->has('datefrom') && $request->datefrom != null) {
                $date = explode(' - ', $request->input('datefrom'));
                $dd1 = $date[0] . '00:00';
                $dd2 = $date[1] . '23:59';
                $date_1 = Carbon::parse($dd1)->format('Y-m-d H:i');
                $date_2 = Carbon::parse($dd2)->format('Y-m-d H:i');
                $data = $data->whereBetween('created_at', [$date_1, $date_2])->orderBy('created_at', 'DESC')->get();
            } else {
                $data = $data->whereDate('created_at', Carbon::now())->orderBy('created_at', 'DESC')->get();
            }

            $pdf = PDF::loadView('export.pdf-detail', compact('data', 'branch', 'date1'));
            \LogActivity::addToLog(Auth::user()->username . ' exporting report (pdf)');
            return $pdf->download('feedback-export.pdf');
        } else {
            $this->exportDetail($request->branch_id, $request->input('datefrom'));
        }
    }

    public function exportSelectIndex(Request $request)
    {
        if ($request->has('pdf')) {
            $data = \App\Models\Branches::query();
            $date1 = $request->datefrom;
            if ($request->has('datefrom') && $request->datefrom != null) {
                $date = explode(' - ', $request->input('datefrom'));
                $dd1 = $date[0] . '00:00';
                $dd2 = $date[1] . '23:59';
                $date_1 = Carbon::parse($dd1)->format('Y-m-d H:i');
                $date_2 = Carbon::parse($dd2)->format('Y-m-d H:i');
                $data = $data->whereHas('survey_branch', function ($q) use ($date_1, $date_2) {
                    $q->whereBetween('created_at', [$date_1, $date_2]);
                })->orderBy('created_at', 'DESC')->get();
            } else {
                $data = $data->whereHas('survey_branch', function ($q) {
                    $q->whereDate('created_at', Carbon::now());
                })->orderBy('created_at')->get();
            }

            \LogActivity::addToLog(Auth::user()->username . ' exporting report (pdf)');
            $pdf = App::make('snappy.pdf.wrapper');
            $pdf->loadView('export.pdf-detail-index', compact('data', 'date1'));
            // $pdf->setPaper('a4')->setOption('margin-top', 0)->setOption('margin-bottom', 0);
            return $pdf->download('feedback-export.pdf');
        } else {
            $this->exportDetailIndex($request->datefrom);
        }
    }
}
