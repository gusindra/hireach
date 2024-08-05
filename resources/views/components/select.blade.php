@props(['data','selected','disabled' => false])

<select {{ $disabled ? 'disabled' : '' }} {!! $attributes->merge(['class' => 'w-full border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 rounded-md shadow-sm dark:bg-slate-800 dark:text-slate-300']) !!}>
    <option>--Select--</option>
    @foreach($data as $key => $d)
        <option value="{{$d[0]}}">{{$d[0]}} {{array_key_exists(1, $d)?' - '.$d[1]:''}}</option>
    @endforeach
   
</select>
{{-- <div>{{$selected}}</div> --}}
