<div wire:poll.5s="refreshData" class="space-y-3">
    @if($challenge)
        <div class="text-sm text-slate-600">Classement pour: <span class="font-semibold text-slate-800">{{ $challenge->title }}</span></div>
    @endif

    @if(empty($leaderboard))
        <div class="p-4 rounded-lg border border-slate-200 text-slate-600 text-sm">Aucun vote pour ce défi pour le moment.</div>
    @else
        <div class="grid grid-cols-1 md:grid-cols-2 gap-3">
            @foreach($leaderboard as $idx => $row)
                <div class="p-3 rounded-lg border border-slate-200">
                    <div class="flex items-center justify-between">
                        <div class="flex items-center gap-3">
                            <div class="w-8 h-8 flex items-center justify-center rounded-full bg-slate-100 text-slate-700 text-xs font-bold">#{{ $idx+1 }}</div>
                            <div class="flex items-center gap-2">
                                @if($row['photo_path'])
                                    <img src="{{ Storage::url($row['photo_path']) }}" alt="{{ $row['name'] }}" class="w-8 h-8 rounded-full object-cover">
                                @else
                                    <div class="w-8 h-8 rounded-full bg-slate-200"></div>
                                @endif
                                <div class="font-medium text-slate-800">{{ $row['name'] }}</div>
                            </div>
                        </div>
                        <div class="text-sm font-semibold text-slate-700">{{ $row['points'] }} pts</div>
                    </div>
                    <div class="mt-2">
                        <div class="h-2 w-full bg-slate-100 rounded-full overflow-hidden">
                            <div class="h-2 bg-emerald-500 rounded-full" style="width: {{ $row['percent'] }}%"></div>
                        </div>
                        <div class="mt-1 text-xs text-slate-500 font-medium">{{ $row['percent'] }}%</div>
                    </div>
                </div>
            @endforeach
        </div>
    @endif
</div>
