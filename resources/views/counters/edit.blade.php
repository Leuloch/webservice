@extends('layouts.app')

@section('content')
    <section class="content-header">
        <h1>
            Counter
        </h1>
   </section>
   <div class="content">
       @include('adminlte-templates::common.errors')
       <div class="box box-primary">
           <div class="box-body">
               <div class="row">
                   {!! Form::model($counter, ['route' => ['counters.update', $counter->id], 'method' => 'patch']) !!}

                        @include('counters.fields')

                   {!! Form::close() !!}
               </div>
           </div>
       </div>
   </div>
@endsection