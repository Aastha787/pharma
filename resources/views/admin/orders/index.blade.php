@extends('layouts.admin')
@section('title','My Orders')
@section('content')
    <div class="py-3 pyt-md-5">
        <div class="container">
            <div class="row">
                <div class="col-md-12 ">
                    <div class="p-3 shadow bg-white">
                        <h2>Orders</h2>
                        <hr>
                        <div class="table-responsive">
                            <table class="table table-bordered table-striped">
                                <thead>
                                <tr>
                                <th>Order ID</th>
                                <th>Tracking No</th>
                                <th>UserName</th>
                                <th>Payment Mode</th>
                                <th>Ordered Date</th>
                                <th>Status Message</th>
                                <th>Action</th>
                                </tr>
                                </thead>
                                <tbody>
                                @forelse($orders as $item)
                                    <tr>
                                        <td>{{$item->id}}</td>
                                        <td>{{$item->tracking_no}}</td>
                                        <td>{{$item->fullname}}</td>
                                        <td>{{$item->payment_mode}}</td>
                                        <td>{{$item->created_at->format('d-m-Y')}}</td>
                                        <td>{{$item->status_message}}</td>
                                        <td><a href="{{url('admin/orders/'.$item->id)}}" class="btn btn-primary btn-sm">View</a></td>
                                    </tr>
                                @empty
                                <tr>
                                    <td colspan="7">No Orders available</td>
                                </tr>
                                    @endforelse
                                </tbody>
                            </table>
                            <div>
                                {{$orders->links()}}
                            </div>
                        </div>
                     </div>

                </div>
            </div>
        </div>
    </div>
@endsection
