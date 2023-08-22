<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Formulir Pemberian Cuti</title>
    <style>
        th {
            font-weight: bold;
        }

        table {
            border-spacing: 0;
            border-collapse: collapse;
            margin-bottom: 35px;
            margin-top: 10px;
            width: 100%;
        }

        tr, th, td {
            border: 1px solid;
            margin: 0;
            padding: 7px;
        }

        .bold {
            font-weight: bold;
        }

        .text-center {
            text-align: center;
        }
    </style>
</head>
<body>
@php
    $leave = @$leave ?? null;
@endphp
<div>
    <img src="{{ public_path('assets/img/header-kop.jpeg') }}" alt="" class="" style="width: 100%;">
</div>
<h3 class="text-center" style="text-transform: uppercase;">Formulir Permintaan dan Pemberian Cuti</h3>
<table>
    <thead>
    <tr>
        <th colspan="4" style="text-align: left;">I. Data Pegawai</th>
    </tr>
    </thead>
    <tbody>
    <tr>
        <td class="bold" style="width: 25%;">Nama</td>
        <td style="width: 25%;">{{ $name }}</td>
        <td class="bold" style="width: 25%;">NIP</td>
        <td style="width: 25%;">{{ $nip }}</td>
    </tr>
    <tr>
        <td class="bold" style="width: 25%;">Golongan</td>
        <td style="width: 75%;" colspan="3">{{ $group }}</td>
    </tr>
    </tbody>
</table>

<table>
    <thead>
    <tr>
        <th colspan="4" style="text-align: left;">II. Jenis Cuti Yang Diambil</th>
    </tr>
    </thead>
    <tbody>
    <tr>
        <td class="bold" style="width: 25%;">1. Cuti Tahunan (12 hari)</td>
        <td style="width: 25%;" class="text-center">
            <x-statement.conditional-if :conditional="$leave_type == \App\Models\Leave::LEAVE_TYPE_ANNUAL_LEAVE">
                <x-icon.img.checkmark></x-icon.img.checkmark>
            </x-statement.conditional-if>
        </td>
        <td class="bold" style="width: 25%;">3. Cuti Melahirkan (3 bulan)</td>
        <td style="width: 25%;" class="text-center">
            <x-statement.conditional-if :conditional="$leave_type == \App\Models\Leave::LEAVE_TYPE_MATERNITY_LEAVE">
                <x-icon.img.checkmark></x-icon.img.checkmark>
            </x-statement.conditional-if>
        </td>
    </tr>
    <tr>
        <td class="bold" style="width: 25%;">2. Cuti Sakit</td>
        <td style="width: 25%;" class="text-center">
            <x-statement.conditional-if :conditional="$leave_type == \App\Models\Leave::LEAVE_TYPE_SICK_LEAVE">
                <x-icon.img.checkmark></x-icon.img.checkmark>
            </x-statement.conditional-if>
        </td>
        <td class="bold" style="width: 25%;">4. Cuti Besar (3 bulan)</td>
        <td style="width: 25%;" class="text-center">
            <x-statement.conditional-if :conditional="$leave_type == \App\Models\Leave::LEAVE_TYPE_BIG_LEAVE">
                <x-icon.img.checkmark></x-icon.img.checkmark>
            </x-statement.conditional-if>
        </td>
    </tr>
    </tbody>
</table>

<table>
    <thead>
    <tr>
        <th style="text-align: left;">III. Alasan Cuti</th>
    </tr>
    </thead>
    <tbody>
    <tr>
        <td style="">{{ $reason }}</td>
    </tr>
    </tbody>
</table>

<table>
    <thead>
    <tr>
        <th colspan="4" style="text-align: left;">IV. Lamanya Cuti</th>
    </tr>
    </thead>
    <tbody>
    <tr>
        <td class="bold" style="width: 25%;">Selama</td>
        <td style="width: 25%;">{{ $total_day }} hari</td>
        <td class="bold" style="width: 25%;">Mulai tanggal</td>
        <td style="width: 25%;">{{ \Carbon\Carbon::parse($start_date)->format('d F Y') }} s/d {{ \Carbon\Carbon::parse($end_date)->format('d F Y') }}</td>
    </tr>
    </tbody>
</table>

<table>
    <tbody>
    <tr>
        <td colspan="2" class="bold" style="text-align: left;">V. Pertimbangan Kepala Bidang Kepegawaian</td>
    </tr>
    <tr>
        <td class="bold" style="width: 25%;">Disetujui</td>
        <td class="bold" style="width: 25%;">Tidak Disetujui</td>
    </tr>
    <tr>
        <td style="width: 25%; height: 50px;" class="text-center">
            @if (@$leave)
                <x-statement.conditional-if :conditional="$leave->isApprovedByHeadOfField()">
                    <x-icon.img.checkmark></x-icon.img.checkmark>
                </x-statement.conditional-if>
            @endif
        </td>
        <td style="width: 25%; height: 50px;" class="text-center">
            @if (@$leave)
                <x-statement.conditional-if :conditional="$leave->isRejectedByHeadOfField()">
                    <x-icon.img.checkmark></x-icon.img.checkmark>
                </x-statement.conditional-if>
            @endif
        </td>
    </tr>
    <tr>
        @php
            $description = optional($leave)->getLeaveApprovedMessage(\App\Models\User::ROLE_HEAD_OF_FIELD);
        @endphp
        <td @if (!$description) style="border-left-style: hidden; border-bottom-style: hidden;" @endif>
            @if($description)
                Ket: <br>
                {{ $description }}
            @endif
        </td>
        <td style="width: 25%; height: 50px;" class="text-center">
            <span style="text-align: left; display: block;">NIP: 999xxx</span>
            <img src="{{ public_path('assets/img/ttd-kepegawaian.png') }}" alt="" style="width: 150px; height: 150px;">
            <span style="display: block;">Test Test</span>
        </td>
    </tr>
    </tbody>
</table>

<table>
    <thead>
    <tr>
        <th colspan="2" style="text-align: left;">VI. Pertimbangan Kepala Dinas</th>
    </tr>
    </thead>
    <tbody>
    <tr>
        <td class="bold" style="width: 25%;">Disetujui</td>
        <td class="bold" style="width: 25%;">Tidak Disetujui</td>
    </tr>
    <tr>
        <td style="width: 25%; height: 50px;" class="text-center">
            @if (@$leave)
                <x-statement.conditional-if :conditional="$leave->isApprovedByHeadOfDepartment()">
                    <x-icon.img.checkmark></x-icon.img.checkmark>
                </x-statement.conditional-if>
            @endif
        </td>
        <td style="width: 25%; height: 50px;" class="text-center">
            @if (@$leave)
                <x-statement.conditional-if :conditional="$leave->isRejectedByHeadOfDepartment()">
                    <x-icon.img.checkmark></x-icon.img.checkmark>
                </x-statement.conditional-if>
            @endif
        </td>
    </tr>
    <tr>
        @php
            $description = optional($leave)->getLeaveApprovedMessage(\App\Models\User::ROLE_HEAD_OF_DEPARTMENT);
        @endphp
        <td @if (!$description) style="border-left-style: hidden; border-bottom-style: hidden;" @endif>
            @if($description)
                Ket: <br>
                {{ $description }}
            @endif
        </td>
        <td style="width: 25%; height: 50px;" class="text-center">
            <span style="text-align: left; display: block;">NIP: 999xxx</span>
            <img src="{{ public_path('assets/img/ttd-kepala-dinas.png') }}" alt="" style="width: 150px; height: 150px;">
            <span style="display: block;">Test Test</span>
        </td>
    </tr>
    </tbody>
</table>
</body>
</html>
