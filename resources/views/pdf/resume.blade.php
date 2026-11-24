<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Curriculum Vitae - {{ $profile->full_name }}</title>
    <style>
        @page {
            margin: 25px 34px 35px;
        }

        * {
            box-sizing: border-box;
        }

        body {
            font-family: DejaVu Sans, sans-serif;
            color: #172338;
            font-size: 9px;
            line-height: 1.55;
        }

        .header {
            background: #080D19;
            color: white;
            padding: 24px;
            border-bottom: 5px solid #38BDF8;
        }

        .header-table {
            width: 100%;
        }

        .header-name {
            font-size: 23px;
            font-weight: bold;
            line-height: 1.25;
            color: #ffffff;
        }

        .headline {
            color: #9DDFFF;
            font-size: 10px;
            margin-top: 7px;
        }

        .contact {
            color: #E5F4FF;
            font-size: 8px;
            margin-top: 12px;
        }

        .photo {
            width: 112px;
            height: 132px;
            object-fit: cover;
            border: 3px solid #38BDF8;
            border-radius: 7px;
        }

        .section {
            margin-top: 17px;
            page-break-inside: avoid;
        }

        .section-title {
            font-size: 11px;
            font-weight: bold;
            color: #075B96;
            text-transform: uppercase;
            border-bottom: 1.5px solid #38BDF8;
            padding-bottom: 5px;
            margin-bottom: 9px;
        }

        .item {
            margin-bottom: 10px;
            page-break-inside: avoid;
        }

        .item-title {
            font-size: 9.5px;
            font-weight: bold;
            color: #101D32;
        }

        .muted {
            color: #64748B;
            font-size: 8px;
        }

        .description {
            margin-top: 3px;
            white-space: pre-line;
        }

        .tag {
            display: inline-block;
            background: #EAF7FD;
            color: #075B96;
            padding: 3px 7px;
            margin: 2px;
            border-radius: 4px;
        }

        .footer {
            position: fixed;
            bottom: -22px;
            left: 0;
            right: 0;
            border-top: 1px solid #D9E6EF;
            padding-top: 6px;
            color: #64748B;
            font-size: 7px;
        }

        a {
            color: #0284C7;
            text-decoration: none;
        }
    </style>
</head>
<body>

<div class="header">
    <table class="header-table">
        <tr>
            <td style="vertical-align: middle;">
                <div class="header-name">
                    {{ $profile->full_name }}
                </div>

                <div class="headline">
                    {{ $profile->headline ?: 'Curriculum Vitae' }}
                </div>

                <div class="contact">
                    @if($profile->email)
                        {{ $profile->email }}<br>
                    @endif

                    @if($profile->phone)
                        {{ $profile->phone }}<br>
                    @endif

                    {{ $profile->location ?: $profile->address }}
                    @if($profile->website)
                        <br>{{ $profile->website }}
                    @endif
                </div>
            </td>

            @if($photoData)
                <td style="width: 125px; text-align: right;">
                    <img src="{{ $photoData }}" class="photo">
                </td>
            @endif
        </tr>
    </table>
</div>

@if($profile->summary)
<div class="section">
    <div class="section-title">Profil Profesional</div>
    <div>{{ $profile->summary }}</div>
</div>
@endif

@if($experiences->isNotEmpty())
<div class="section">
    <div class="section-title">Pengalaman</div>

    @foreach($experiences as $item)
        <div class="item">
            <div class="item-title">
                {{ $item->position }} — {{ $item->company }}
            </div>

            <div class="muted">
                {{ $item->location }}
                @if($item->start_date)
                    · {{ $item->start_date->format('M Y') }}
                @endif
                –
                {{ $item->is_current ? 'Sekarang' : ($item->end_date?->format('M Y') ?? 'Selesai') }}
            </div>

            @if($item->description)
                <div class="description">{{ $item->description }}</div>
            @endif
        </div>
    @endforeach
</div>
@endif

@if($educations->isNotEmpty())
<div class="section">
    <div class="section-title">Pendidikan</div>

    @foreach($educations as $item)
        <div class="item">
            <div class="item-title">{{ $item->institution }}</div>
            <div>
                {{ $item->degree }}
                @if($item->field_of_study)
                    — {{ $item->field_of_study }}
                @endif
            </div>
            <div class="muted">
                {{ $item->location }}
                @if($item->start_date)
                    · {{ $item->start_date->format('Y') }}
                @endif
                –
                {{ $item->is_current ? 'Sekarang' : ($item->end_date?->format('Y') ?? '') }}
            </div>
            @if($item->description)
                <div>{{ $item->description }}</div>
            @endif
        </div>
    @endforeach
</div>
@endif

@if($skills->isNotEmpty())
<div class="section">
    <div class="section-title">Keahlian</div>
    @foreach($skills as $item)
        <span class="tag">{{ $item->name }}</span>
    @endforeach
</div>
@endif

@if($certificates->isNotEmpty())
<div class="section">
    <div class="section-title">Sertifikat</div>
    @foreach($certificates as $item)
        <div class="item">
            <div class="item-title">{{ $item->title }}</div>
            <div class="muted">
                {{ $item->issuer }}
                @if($item->issue_date)
                    · {{ $item->issue_date->format('M Y') }}
                @endif
            </div>
            @if($item->credential_url)
                <a href="{{ $item->credential_url }}">{{ $item->credential_url }}</a>
            @endif
        </div>
    @endforeach
</div>
@endif

@if($projects->isNotEmpty())
<div class="section">
    <div class="section-title">Proyek & Portofolio</div>
    @foreach($projects as $item)
        <div class="item">
            <div class="item-title">{{ $item->title }}</div>
            @if($item->role)
                <div class="muted">{{ $item->role }}</div>
            @endif
            @if($item->description)
                <div>{{ $item->description }}</div>
            @endif
            @if($item->technologies)
                <div class="muted">
                    Teknologi: {{ implode(', ', $item->technologies) }}
                </div>
            @endif
            @if($item->project_url)
                <a href="{{ $item->project_url }}">{{ $item->project_url }}</a>
            @endif
        </div>
    @endforeach
</div>
@endif

@if($socialLinks->isNotEmpty())
<div class="section">
    <div class="section-title">Media Sosial</div>
    @foreach($socialLinks as $item)
        <div>
            <strong>{{ $item->label ?: $item->platform }}</strong>:
            {{ $item->url }}
        </div>
    @endforeach
</div>
@endif

<div class="footer">
    CURRICULUM VITAE · {{ $profile->full_name }}
</div>

</body>
</html>