@php use App\Tools\CalendarTools; @endphp
<div class="offcanvas offcanvas-start glass-item" data-bs-scroll="true" tabindex="-1" id="sidebar"
     aria-labelledby="sidebar">
    <div class="offcanvas-header">
        <h5 class="offcanvas-title" id="sidebar">
            My finances planner
        </h5>
    </div>
    <div class="offcanvas-body">
        {{ CalendarTools::salutation(Auth::user()->name, date('H')) }}
    </div>
</div>