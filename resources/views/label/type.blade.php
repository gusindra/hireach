@if(in_array(strtolower($type), ['saas', 'credit', 'delivered', 'started']))
<span class="border border-transparent bg-green-600 dark:text-slate-300 text-green-100 text-xs text-center uppercase py-1 px-2 rounded-sm">{{$type}}</span>
@elseif(in_array(strtolower($type), ['selling','undelivered','pending']))
<span class="border border-transparent bg-pink-500 dark:text-slate-300 text-yellow-100 text-xs text-center uppercase py-1 px-2 rounded-sm">{{$type}}</span>
@elseif(in_array(strtolower($type), ['failed','debit']) || str_contains($type, 'Reject') || str_contains(strtolower($type), 'invalid') )
<span class="border border-transparent bg-red-600 dark:text-slate-300 text-red-100 text-xs text-center uppercase py-1 px-2 rounded-sm">{{$type}}</span>
@elseif(in_array(strtolower($type), ['referral','submit','accepted','success','starting']))
<span class="border border-transparent bg-blue-600 dark:text-slate-300 text-blue-100 text-xs text-center uppercase py-1 px-2 rounded-sm">{{$type}}</span>
@elseif($type!='')
<span>{{$type}}</span>
@endif
