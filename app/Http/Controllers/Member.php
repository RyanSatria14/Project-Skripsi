<?php

namespace App\Http\Controllers;

use App\Models\ComplaintSuggestion;
use Illuminate\Http\Request;
use App\Models\PriceList;
use App\Models\ServiceType;
use App\Models\Transaction;
use App\Models\TransactionDetail;
use App\Models\User;
use App\Models\UserVoucher;
use App\Models\Voucher;
use App\Models\Notifikasi;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use PDF;

class Member extends Controller
{
    /**
     * Fungsi untuk menampilkan halaman dashboard member (Beranda)
     */
    public function index()
    {
        $user = Auth::user();
        $transaksi_terakhir = Transaction::where('member_id', $user->id)
            ->orderBy('created_at', 'DESC')
            ->orderBy('status_id', 'ASC')
            ->limit(10)
            ->get();

        return view('member.index', compact('user', 'transaksi_terakhir'));
    }

    public function notifikasi()
    {
        $user = Auth::user();
        return view('member.notifikasi',compact('user'));
    }

    public function detailNotifikasi(Request $request)
    {
        $detail_notif = DB::table('notifications')->where('id', $request->input('id'))->get();
        DB::table('notifications')->where('id', $request->input('id'))->update(['read' => 'Y']);
        echo json_encode($detail_notif);
    }

    /**
     * Fungsi untuk menampilkan daftar harga
     */
    public function harga()
    {
        $user = Auth::user();
        $satuan = PriceList::where('category_id', 1)->get();
        $kiloan = PriceList::where('category_id', 2)->get();
        $serviceType = ServiceType::all();

        return view('member.harga', compact('user', 'satuan', 'kiloan', 'serviceType'));
    }

    public function getDataService(Request $request)
    {
        $columns = array( 
                            0 =>'id', 
                            1 =>'name', 
                            2 =>'cost',
                            4 => 'aksi',
                        );

        $limit = $request->input('length');
        $start = $request->input('start');
        $order = $columns[$request->input('order.0.column')];
        $dir = $request->input('order.0.dir');
        $search = $request->input('search.value');
  
        $totalData = ServiceType::count();

        $query_data =ServiceType::where(function($query) use ($search)
                    {
                        if(!empty($search)){
                            $query->where('name','LIKE',"%{$search}%")
                              ->orWhere('cost', 'LIKE',"%{$search}%");
                        }
                        
                    });

        $all_data=$query_data->offset($start)->limit($limit)->orderBy($order,$dir)->get();

        $totalFiltered = $query_data->count();

        $data = array();
       
        $no=1;
        if(!empty($all_data))
        {
            foreach ($all_data as $row)
            {
                $btn="";
                   
                $nestedData['no'] = $no++;
                $nestedData['id'] = $row->id;
                $nestedData['name'] = $row->name;
                $nestedData['cost'] = 'Rp. '.number_format($row->cost, 0, ',', '.');
                $nestedData['aksi'] = $btn;
                $data[] = $nestedData;

            }
        }
          
        $json_data = array(
                    "draw"            => intval($request->input('draw')),  
                    "recordsTotal"    => intval($totalData),  
                    "recordsFiltered" => intval($totalFiltered), 
                    "data"            => $data   
                    );
            
        return json_encode($json_data);
    }


    public function getDataKiloan(Request $request)
    {
        $columns = array( 
                            0 =>'id', 
                            1 =>'nm_brg', 
                            2 =>'nm_service',
                            3 =>'price',
                            4 => 'aksi',
                        );

        $limit = $request->input('length');
        $start = $request->input('start');
        $order = $columns[$request->input('order.0.column')];
        $dir = $request->input('order.0.dir');
        $search = $request->input('search.value');
  
        $totalData = PriceList::where('category_id', 2)->count();

        $query_data =DB::table('price_lists')
                    ->select('price_lists.*','items.name as nm_brg','services.name as nm_service')
                    ->join('items','items.id','price_lists.item_id')
                    ->join('services','services.id','price_lists.service_id')
                    ->where('price_lists.category_id', 2)
                    ->where(function($query) use ($search)
                    {
                        if(!empty($search)){
                            $query->where('price_lists.price','LIKE',"%{$search}%")
                              ->orWhere('items.name', 'LIKE',"%{$search}%")
                              ->orWhere('services.name', 'LIKE',"%{$search}%");
                        }
                        
                    });

        $all_data=$query_data->offset($start)->limit($limit)->orderBy($order,$dir)->get();

        $totalFiltered = $query_data->count();

        $data = array();
       
        $no=1;
        if(!empty($all_data))
        {
            foreach ($all_data as $row)
            {
                $btn="";
                   
                $nestedData['no'] = $no++;
                $nestedData['id'] = $row->id;
                $nestedData['nm_brg'] = $row->nm_brg;
                $nestedData['nm_service'] = $row->nm_service;
                $nestedData['price'] = number_format($row->price, 0, ',', '.');
                $nestedData['aksi'] = $btn;
                $data[] = $nestedData;

            }
        }
          
        $json_data = array(
                    "draw"            => intval($request->input('draw')),  
                    "recordsTotal"    => intval($totalData),  
                    "recordsFiltered" => intval($totalFiltered), 
                    "data"            => $data   
                    );
            
        return json_encode($json_data);
    }

    public function getDataSatuan(Request $request)
    {
                $columns = array( 
                            0 =>'id', 
                            1 =>'nm_brg', 
                            2 =>'nm_service',
                            3 =>'price',
                            4 => 'aksi',
                        );

        $limit = $request->input('length');
        $start = $request->input('start');
        $order = $columns[$request->input('order.0.column')];
        $dir = $request->input('order.0.dir');
        $search = $request->input('search.value');
  
        $totalData = PriceList::where('category_id', 1)->count();

        $query_data =DB::table('price_lists')
                    ->select('price_lists.*','items.name as nm_brg','services.name as nm_service')
                    ->join('items','items.id','price_lists.item_id')
                    ->join('services','services.id','price_lists.service_id')
                    ->where('price_lists.category_id', 1)
                    ->where(function($query) use ($search)
                    {
                        if(!empty($search)){
                            $query->where('price_lists.price','LIKE',"%{$search}%")
                              ->orWhere('items.name', 'LIKE',"%{$search}%")
                              ->orWhere('services.name', 'LIKE',"%{$search}%");
                        }
                        
                    });

        $all_data=$query_data->offset($start)->limit($limit)->orderBy($order,$dir)->get();

        $totalFiltered = $query_data->count();

        $data = array();
       
        $no=1;
        if(!empty($all_data))
        {
            foreach ($all_data as $row)
            {
                $btn="";
                   
                $nestedData['no'] = $no++;
                $nestedData['id'] = $row->id;
                $nestedData['nm_brg'] = $row->nm_brg;
                $nestedData['nm_service'] = $row->nm_service;
                $nestedData['price'] = number_format($row->price, 0, ',', '.');
                $nestedData['aksi'] = $btn;
                $data[] = $nestedData;

            }
        }
          
        $json_data = array(
                    "draw"            => intval($request->input('draw')),  
                    "recordsTotal"    => intval($totalData),  
                    "recordsFiltered" => intval($totalFiltered), 
                    "data"            => $data   
                    );
            
        return json_encode($json_data);
    }

    /**
     * Fungsi untuk menampilkan halaman riwayat transaksi member
     */
    public function riwayatTransaksi()
    {
        $user = Auth::user();
        $transaksi = Transaction::where('member_id', $user->id)
            ->orderBy('created_at', 'DESC')
            ->orderBy('status_id', 'ASC')
            ->get();
        return view('member.riwayat', compact('user', 'transaksi'));
    }


    public function getTransaksi(Request $request)
    {

    $columns = array( 
                0 =>'id', 
                1 =>'created_at', 
                2 =>'stt',
                3 => 'aksi',
            );

        $limit = $request->input('length');
        $start = $request->input('start');
        $order = $columns[$request->input('order.0.column')];
        $dir = $request->input('order.0.dir');
        $search = $request->input('search.value');
        $user = Auth::user();
  
        $totalData = Transaction::select('transactions.*','users.name as nm_member','statuses.name as stt_name')
                    ->join('users','users.id','transactions.member_id')
                    ->join('statuses','statuses.id','transactions.status_id')
                    ->where('transactions.member_id', $user->id)->count();


        $query_data =Transaction::select('transactions.*','users.name as nm_member','statuses.name as stt_name')
                    ->join('users','users.id','transactions.member_id')
                    ->join('statuses','statuses.id','transactions.status_id')
                    ->where('transactions.member_id', $user->id)
                    ->where(function($query) use ($search)
                    {
                        if(!empty($search)){
                            $query->where('transactions.id','LIKE',"%{$search}%")
                              ->orWhere('transactions.created_at', 'LIKE',"%{$search}%");
                        }
                        
                    });

        $all_data=$query_data->offset($start)->limit($limit)->orderBy($order,$dir)->get();

        $totalFiltered = $query_data->count();

        $data = array();
       
        $no=1;
        if(!empty($all_data))
        {
            foreach ($all_data as $row)
            {

                $btn="";
                $btn.='<a href="'.url('member/transaksi') . '/' . $row->id.'" class="badge badge-primary">Lihat Detail ></a>';

                $stt="";
                if ($row->status_id != '3'){
                    $stt.='<span class="text-warning">'.$row->stt_name.'</span>';
                }else{
                    $stt.='<span class="text-success">'.$row->stt_name.'</span>';
                }
                   
                $nestedData['no'] = $no++;
                $nestedData['id'] = $row->id;
                $nestedData['created_at'] = date('d/m/Y',strtotime($row->created_at));
                $nestedData['nm_member'] = $row->nm_member;
                $nestedData['stt'] = $stt;
                $nestedData['service_cost'] = 'Rp.'.number_format($row->service_cost, 0, ',', '.');
                $nestedData['total'] = 'Rp.'.number_format($row->total, 0, ',', '.');
                $nestedData['aksi'] = $btn;
                $data[] = $nestedData;

            }
        }
          
        $json_data = array(
                    "draw"            => intval($request->input('draw')),  
                    "recordsTotal"    => intval($totalData),  
                    "recordsFiltered" => intval($totalFiltered), 
                    "data"            => $data   
                    );
            
        return json_encode($json_data);
    }

    /**
     * Fungsi untuk menampilkan halaman poin
     */
    public function poin()
    {
        $user = Auth::user();
        $vouchers = Voucher::where('active_status', 1)->get();
        $memberVouchers = UserVoucher::where([
            'user_id' => $user->id,
            'used' => 0
        ])->get();
        return view('member.poin', compact('user', 'vouchers', 'memberVouchers'));
    }

    /**
     * Fungsi untuk menukar poin
     */
    public function tukarPoin($id_voucher)
    {
        $user = User::where('email', '=', Auth::user()->email)->first();

        // Ambil data poin yang diperlukan untuk menukar voucher
        $voucher = Voucher::where('id', $id_voucher)->first();

        // Cek apakah poin member mencukupi untuk menukar voucher
        // Jika poin mencukupi, tambahkan ke tabel users voucher
        if ($user->point >= $voucher->point_need) {
            $user_voucher = new UserVoucher([
                'voucher_id' => $id_voucher,
                'user_id' => $user->id,
                'used' => 0
            ]);
            $user_voucher->save();

            // Update point member
            $user->point = $user->point - $voucher->point_need;
            $user->save();

            //Redirect ke poin dan pesan sukses
            return redirect('member/poin')->with('success', 'Poin berhasil ditukar menjadi voucher!');
        } else {
            return redirect('member/poin')->with('error', 'Poin tidak mencukupi untuk menukar voucher!');
        }
    }

    /**
     * Fungsi untuk menampilkan halaman saran komplain
     */
    public function saranKomplain()
    {
        $user = Auth::user();
        $saran_komplain = ComplaintSuggestion::where('user_id', $user->id)->get();
        return view('member.saran', compact('user', 'saran_komplain'));
    }

    /**
     * Fungsi untuk mengirimkan saran komplain
     */
    public function kirimSaranKomplain(Request $request)
    {
        $request->validate([
            'isi_sarankomplain' => 'required'
        ]);

        $user = Auth::user();

        $complaint_suggestion = new ComplaintSuggestion([
            'body' => $request->input('isi_sarankomplain'),
            'type' => $request->input('tipe'),
            'user_id' => $user->id,
            'reply' => ''
        ]);
        
        $notif = new Notifikasi([
            'jd' => "Terdapat saran / komplain baru",
            'ket' => "Periksa Saran dan Komplain",
            'read'=>'N',
            'untuk'=>'admin',
        ]);
        
        $notif->save();

        $complaint_suggestion->save();
        
        DB::commit();

        return redirect('member/saran')->with('success', 'Saran/komplain berhasil dikirim!');
    }

    /**
     * Fungsi untuk menampilkan halaman detail transaksi
     */
    public function detailTransaksi($id_transaksi)
    {
        $user = Auth::user();
        $transaksi = TransactionDetail::where('transaction_id', $id_transaksi)->get();
        return view('member.detail', compact('user', 'transaksi', 'id_transaksi'));
    }
}
