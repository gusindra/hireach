@if($mutation=='debit')
<div class="relative z-10 inline-block m-0 font-semibold leading-normal text-transparent bg-gradient-to-tl from-red-600 to-rose-400 text-sm bg-clip-text">- {{number_format($amount)}}</div>
@elseif($mutation=='credit')
<div class="relative z-10 inline-block m-0 font-semibold leading-normal text-transparent bg-gradient-to-tl from-green-600 to-lime-400 text-sm bg-clip-text">{{number_format($amount)}}</div>
@else
<div>{{number_format($amount)}}</div>
@endif
