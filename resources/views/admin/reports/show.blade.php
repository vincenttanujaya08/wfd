{{-- resources/views/admin/reports/show.blade.php --}}
@extends('admin.layouts.template')
@section('title', 'Report #' . $report->id)

@section('head')
    <style>
        /* =============== slider & grid =============== */
        .image-container {
            max-width: 800px;
            height: 450px;
            position: relative;
            margin: auto;
            overflow: hidden;
            background: #000;
        }

        .slide {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            display: none;
        }

        .slide img {
            width: 100%;
            height: 100%;
            object-fit: contain;
            background: #000;
        }

        .slideNumber {
            position: absolute;
            top: 8px;
            right: 8px;
            background: rgba(85, 116, 197, .7);
            color: #fff;
            padding: 5px 10px;
            border-radius: 25px;
            font-weight: bold;
        }

        .previous,
        .next {
            position: absolute;
            top: 50%;
            padding: 16px;
            margin-top: -22px;
            background: rgba(0, 0, 0, .4);
            color: #fff;
            border-radius: 50%;
            cursor: pointer;
        }

        .previous {
            left: 16px
        }

        .next {
            right: 16px
        }

        .footerdot {
            display: inline-block;
            width: 15px;
            height: 15px;
            margin: 0 4px;
            background: #bbb;
            border-radius: 50%;
            cursor: pointer;
            transition: background-color .3s
        }

        .active,
        .footerdot:hover {
            background: #717171
        }

        .detail-grid {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 2rem;
            align-items: stretch;
            margin-top: 2rem;
        }

        .info-card {
            background: #fff;
            padding: 1.5rem;
            border-radius: .5rem
        }

        .info-card.right-panel {
            display: flex;
            flex-direction: column
        }

        .description-content {
            flex: 1
        }

        .actions {
            display: flex;
            justify-content: center;
            gap: 1rem;
            margin-top: 1rem
        }

        .actions button {
            padding: .75rem 1.25rem;
            border: none;
            border-radius: .375rem;
            color: #fff;
            cursor: pointer
        }

        .btn-cancel {
            background: #6b7280
        }

        .btn-warning {
            background: #f59e0b
        }

        .btn-ban {
            background: #ef4444
        }

        /* =============== codingNepal modal =============== */
        section {
            position: relative;
            min-height: 100vh;
        }

        section.show .profile {
            display: none
        }

        .popup-outer {
            display: flex;
            align-items: center;
            justify-content: center;
            position: absolute;
            inset: 0;
            background: rgba(0, 0, 0, 0.3);
            opacity: 0;
            pointer-events: none;
            transform: scale(1.2);
            transition: opacity .2s ease, transform .2s ease;
        }

        section.show .popup-outer {
            opacity: 1;
            pointer-events: auto;
            transform: scale(1);
        }

        .popup-box {
            background: #fff;
            border-radius: 12px;
            padding: 30px;
            max-width: 380px;
            width: 100%;
            position: relative;
            color:
        }

        .popup-box .close {
            position: absolute;
            top: 16px;
            right: 16px;
            font-size: 24px;
            color: #b4b4b4;
            cursor: pointer;
            transition: color .2s;
        }

        .popup-box .close:hover {
            color: #333
        }

        .popup-box textarea {
            width: 100%;
            min-height: 140px;
            resize: none;
            outline: none;
            border: 1px solid #ddd;
            border-radius: 6px;
            padding: 10px;
            background: #f3f3f3;
            font-size: 14px;
        }

        .popup-box .button {
            display: flex;
            justify-content: flex-end;
            margin-top: 15px;
        }

        .popup-box .button button {
            border: none;
            padding: 6px 12px;
            border-radius: 4px;
            cursor: pointer;
            color: #fff;
            font-size: 14px;
            transition: background .3s;
        }

        .popup-box .button .cancel {
            background: #f082ac
        }

        .popup-box .button .cancel:hover {
            background: #ec5f95
        }

        .popup-box .button .send {
            background: #4070f4
        }

        .popup-box .button .send:hover {
            background: #275df1
        }

        .popup-box label {
            display: block;
            margin-top: 1rem;
            margin-bottom: .5rem;
            color: #000;
        }

        .popup-box input[type="date"],
        .popup-box textarea {
            margin-bottom: 1rem;
        }
    </style>
@endsection

@section('content')
    <section>
        {{-- your slider --}}
        <div class="image-container">
            @foreach ($report->images as $i => $img)
                <div class="slide">
                    <div class="slideNumber">{{ $i + 1 }}</div>
                    <img src="{{ asset('storage/' . $img->image_path) }}" alt="">
                </div>
            @endforeach
            <a class="previous" onclick="moveSlides(-1)"><i class="fa fa-chevron-circle-left"></i></a>
            <a class="next" onclick="moveSlides(1)"><i class="fa fa-chevron-circle-right"></i></a>
        </div>
        <div style="text-align:center;margin-top:8px">
            @foreach ($report->images as $i => $img)
                <span class="footerdot" onclick="activeSlide({{ $i + 1 }})"></span>
            @endforeach
        </div>

        {{-- detail panels --}}
        <div class="detail-grid">
            <div class="info-card" style="color:black;">
                <h2>Reporter</h2>
                <p>{{ $report->reporter->name }}<br>{{ $report->reporter->email }}</p>
                <hr>
                <h2>Reported User</h2>
                <p>{{ $report->reportedUser->name }}<br>{{ $report->reportedUser->email }}</p>
            </div>
            <div class="info-card right-panel">
                <div class="description-content" style="color:black;">
                    <h2>Description</h2>
                    <p>{{ $report->description }}</p>
                </div>
            </div>
        </div>

        {{-- action buttons --}}
        <div class="actions">
            <form action="{{ route('admin.reports.handle', $report) }}" method="POST">
                @csrf
                <button name="action" value="cancel" class="btn-cancel">Delete</button>
                <button name="action" value="warning" class="btn-warning">Warning</button>
            </form>
            <button class="btn-ban" onclick="document.querySelector('section').classList.add('show')">Ban User</button>
        </div>

        {{-- popup modal --}}
        {{-- popup modal --}}
        <div class="popup-outer">
            <div class="popup-box">
                {{-- tombol close --}}
                <i class="bx bx-x close" onclick="document.querySelector('section').classList.remove('show')">
                </i>

                <h2 style="color: #000">Ban User</h2>
                <form action="{{ route('admin.bans.store') }}" method="POST">
                    @csrf
                    <input type="hidden" name="user_id" value="{{ $report->reported_user_id }}">
                    <input type="hidden" name="report_id" value="{{ $report->id }}">

                    {{-- Ban Until --}}
                    <label for="banned_until" style="display:block; margin-top:1rem; font-weight:500; color: #000;">
                        Ban Until
                    </label>
                    <input id="banned_until" name="banned_until" type="date"
                        class="w-full border rounded px-3 py-2 mb-4" />

                    {{-- Reason --}}
                    <label for="reason" style="display:block; font-weight:500; margin-bottom:.5rem; color: #000;">
                        Reason
                    </label>
                    <textarea id="reason" name="reason" required class="w-full border rounded px-3 py-2"
                        placeholder="Why are you banning this user?"></textarea>

                    <div class="button">
                        <button type="button" class="cancel"
                            onclick="document.querySelector('section').classList.remove('show')">Cancel</button>
                        <button type="submit" class="send">Confirm Ban</button>
                    </div>
                </form>
            </div>
        </div>

    </section>
@endsection

@section('scripts')
    <script>
        let slideIndex = 1;
        showSlide(slideIndex);

        function moveSlides(n) {
            showSlide(slideIndex += n)
        }

        function activeSlide(n) {
            showSlide(slideIndex = n)
        }

        function showSlide(n) {
            let s = document.getElementsByClassName('slide'),
                d = document.getElementsByClassName('footerdot');
            if (n > s.length) slideIndex = 1;
            if (n < 1) slideIndex = s.length;
            for (let i = 0; i < s.length; i++) s[i].style.display = 'none';
            for (let i = 0; i < d.length; i++) d[i].classList.remove('active');
            s[slideIndex - 1].style.display = 'block';
            d[slideIndex - 1].classList.add('active');
        }
    </script>
@endsection
