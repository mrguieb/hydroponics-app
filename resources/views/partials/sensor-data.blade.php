@if($data->isNotEmpty())
<div class="cards">
    <div class="card">
        <h2 class="{{ $data[0]->temperature > 35 ? 'highlight-hot' : '' }}">
            {{ $data[0]->temperature }}°C
        </h2>
        <p>Temperature</p>
    </div>
    <div class="card">
        <h2 class="{{ $data[0]->humidity > 80 ? 'highlight-humid' : '' }}">
            {{ $data[0]->humidity }}%
        </h2>
        <p>Humidity</p>
    </div>
    <div class="card">
        <h2>{{ $data[0]->ldr_analog }}</h2>
        <p>LDR Analog</p>
    </div>
    <div class="card">
        <h2 class="{{ $data[0]->ldr_digital ? 'highlight-bright' : '' }}">
            {{ $data[0]->ldr_digital ? 'Bright' : 'Dark' }}
        </h2>
        <p>LDR Digital</p>
    </div>
    <div class="card">
        <h2 class="{{ $data[0]->distance < 5 ? 'highlight-water-low' : '' }}">
            {{ $data[0]->distance }} cm
        </h2>
        <p>Water Level</p>
    </div>
</div>
@endif
<div class="table-responsive">
<table>
    <thead>
        <tr>
            <th>Temperature</th>
            <th>Humidity</th>
            <th>LDR Analog</th>
            <th>LDR Digital</th>
            <th>Water Level</th>
            <th>Time</th>
        </tr>
    </thead>
    <tbody>
        @foreach($data as $item)
        <tr>
            <td class="{{ $item->temperature > 35 ? 'highlight-hot' : '' }}">{{ $item->temperature }}°C</td>
            <td class="{{ $item->humidity > 80 ? 'highlight-humid' : '' }}">{{ $item->humidity }}%</td>
            <td>{{ $item->ldr_analog }}</td>
            <td class="{{ $item->ldr_digital ? 'highlight-bright' : '' }}">{{ $item->ldr_digital ? 'Bright' : 'Dark' }}</td>
            <td class="{{ $item->distance < 3 ? 'highlight-water-normal' : '' }}">{{ $item->ldr_digital ? 'Normal' : 'Low' }}</td>
            <td>{{ $item->created_at->format('M d, Y H:i:s') }}</td>
        </tr>
        @endforeach
    </tbody>
</table>
</div>
