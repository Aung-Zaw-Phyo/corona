@extends('backend.layouts.app')
@section('title', 'Dashboard')
@section('content')
  <div class="row mb-3">
    <div class="col-xl-3 col-sm-6 grid-margin stretch-card">
      <div class="card">
        <div class="card-body">
          <div class="row">
            <div class="col-9">
              <div class="d-flex align-items-center align-self-start">
                <h3 class="mb-0">$12.34</h3>
                <p class="text-success ml-2 mb-0 font-weight-medium">+3.5%</p>
              </div>
            </div>
            <div class="col-3">
              <div class="icon icon-box-success ">
                <span class="mdi mdi-arrow-top-right icon-item"></span>
              </div>
            </div>
          </div>
          <h6 class="text-muted font-weight-normal">Potential growth</h6>
        </div>
      </div>
    </div>
    <div class="col-xl-3 col-sm-6 grid-margin stretch-card">
      <div class="card">
        <div class="card-body">
          <div class="row">
            <div class="col-9">
              <div class="d-flex align-items-center align-self-start">
                <h3 class="mb-0">$17.34</h3>
                <p class="text-success ml-2 mb-0 font-weight-medium">+11%</p>
              </div>
            </div>
            <div class="col-3">
              <div class="icon icon-box-success">
                <span class="mdi mdi-arrow-top-right icon-item"></span>
              </div>
            </div>
          </div>
          <h6 class="text-muted font-weight-normal">Revenue current</h6>
        </div>
      </div>
    </div>
    <div class="col-xl-3 col-sm-6 grid-margin stretch-card">
      <div class="card">
        <div class="card-body">
          <div class="row">
            <div class="col-9">
              <div class="d-flex align-items-center align-self-start">
                <h3 class="mb-0">$12.34</h3>
                <p class="text-danger ml-2 mb-0 font-weight-medium">-2.4%</p>
              </div>
            </div>
            <div class="col-3">
              <div class="icon icon-box-danger">
                <span class="mdi mdi-arrow-bottom-left icon-item"></span>
              </div>
            </div>
          </div>
          <h6 class="text-muted font-weight-normal">Daily Income</h6>
        </div>
      </div>
    </div>
    <div class="col-xl-3 col-sm-6 grid-margin stretch-card">
      <div class="card">
        <div class="card-body">
          <div class="row">
            <div class="col-9">
              <div class="d-flex align-items-center align-self-start">
                <h3 class="mb-0">$31.53</h3>
                <p class="text-success ml-2 mb-0 font-weight-medium">+3.5%</p>
              </div>
            </div>
            <div class="col-3">
              <div class="icon icon-box-success ">
                <span class="mdi mdi-arrow-top-right icon-item"></span>
              </div>
            </div>
          </div>
          <h6 class="text-muted font-weight-normal">Expense current</h6>
        </div>
      </div>
    </div>
  </div>

  <h3 class="mb-3">Today Booking List</h3>
  <div class="row mb-3">
    @foreach ($booking_lists as $booking)
    <div class="col-md-6 col-xl-4 grid-margin stretch-card">
      <div class="card  h-100">
        <div class="card-body p-3">
          <div class="mb-3">
              <p class=" mb-1"><i class="fa-solid fa-user me-2"></i> Name</p>
              <p class="mb-1">{{ $booking->name }}</p>
          </div>
          <div class="mb-3">
              <p class=" mb-1"><i class="fa-solid fa-phone me-2"></i> Phone</p>
              <p class="mb-1">{{ $booking->phone }}</p>
          </div>
          <div class="mb-3">
              <p class=" mb-1"><i class="fa-solid fa-envelope me-2"></i> Email</p>
              <p class="mb-1">{{ $booking->email ? $booking->email : '...' }}</p>
          </div>
          <div class="mb-3">
              <p class=" mb-1"><i class="fa-solid fa-users me-2"></i> Person</p>
              <p class="mb-1"><span class="badge badge-primary">{{ $booking->person }}</span></p>
          </div>
          <div class="mb-3">
              <p class=" mb-1"><i class="fa-solid fa-calendar-days me-2"></i> Date</p>
              <p class="mb-1"><span class="badge badge-primary">{{ $booking->date }}</span></p>
          </div>
          <div class="mb-3">
              <p class=" mb-1"><i class="fa-solid fa-clock me-2"></i> Time</p>
              <p class="mb-1"><span class="badge badge-primary">{{ $booking->time }}</span></p>
          </div>
          <div class="mb-3">
              <p class=" mb-1"><i class="fa-solid fa-message me-2"></i> Message</p>
              <p class="mb-1">{{ $booking->message ? $booking->message : '...' }}</p>
          </div>
      </div>
      </div>
    </div>
    @endforeach
  </div>

  <h3 class="mb-3">Today Orders</h3>
  <div class="row mb-3">
    @foreach ($orders as $order)
    <div class="col-md-6 col-xl-4 grid-margin stretch-card">
      <div class="card h-100 relative order-card">
        <div class="card-body p-3">
          <div class="order-status">
              @if ($order->status == 'paid')
                  <form action="{{ route('order.complete', $order->id) }}" method="POST">
                      @csrf
                      <button class="status-icon paid"><i class="fa-solid fa-truck paid"></i></button>
                  </form>
              @endif
              @if ($order->status == 'completed')
                  <span class="status-icon completed"><i class="fa-solid fa-check"></i></span>
              @endif
          </div>
          <div class="mb-3">
              <p class=" mb-1">Order Number</p>
              <p class="mb-1">{{ $order->order_no }}</p>
          </div>
          <div class="mb-3">
              <p class=" mb-1">Order Status</p>
              <p class="mb-1"><span class="badge p-1 text-uppercase badge-primary">{{ $order->status }}</span></p>
          </div>
          <div class="mb-3">
              <p class=" mb-1">Name</p>
              <p class="mb-1">{{ $order->name }}</p>
          </div>
          <div class="mb-3">
              <p class=" mb-1">Phone</p>
              <p class="mb-1">{{ $order->phone }}</p>
          </div>
          <div class="mb-3">
              <p class=" mb-1">Address</p>
              <p class="mb-1">{{ $order->address }}</p>
          </div>
          <div class="mb-3">
              <p class=" mb-1">Message</p>
              <p class="mb-1">{{ $order->message ? $order->message : '...' }}</p>
          </div>
          <div class="mb-3">
              <p class=" mb-1">Date_Time</p>
              <p class="mb-1">{{ $order->created_at->diffForHumans() }}</p>
          </div>
      </div>
      </div>
    </div>
    @endforeach
  </div>
@endsection


          