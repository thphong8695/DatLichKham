<div class="horizontal-main hor-menu clearfix">
    <div class="horizontal-mainwrapper container clearfix">
        <nav class="horizontalMenu clearfix">
            <ul class="horizontalMenu-list">
                <li aria-haspopup="true"><a href="{{ route('dat-lich-kham.index') }}" class="sub-icon {{Request::is('dat-lich-kham*') || Request::is('/') ? 'active' : '' }}"><i class="side-menu__icon fe fe-monitor"></i> Trang chủ<i class="side-menu__icon fe fe-chevron-down"></i>
                </a>
                    <ul class="sub-menu">
                        <li aria-haspopup="true">
                            <a href="{{ route('vac-xin.chitiet') }}" class="sub-icon {{Request::is('chi-tiet-vac-xin*') ? 'active' : '' }}">Chi tiết vắc-xin</a>
                        </li>
                    </ul>
                </li>

            	@can('DlBv106x-edit')
                <li aria-haspopup="true">
                    <a href="{{ route('benh-vien.index') }}" class="sub-icon {{Request::is('benh-vien*') || Request::is('chuyen-khoa*') || Request::is('bac-si*') || Request::is('khung-gio*') || Request::is('tuychinh-khunggio*') || Request::is('tuychinh-ngayoff*') ? 'active' : '' }}">
                        <i class="side-menu__icon fe fe-monitor"></i> Bệnh viện<i class="side-menu__icon fe fe-chevron-down"></i>
                    </a>
                    <ul class="sub-menu">
                        <li aria-haspopup="true">
                            <a href="{{ route('chuyen-khoa.index') }}" class="sub-icon {{Request::is('chuyen-khoa*') ? 'active' : '' }}">Chuyên khoa </a>
                        </li>
                        <li aria-haspopup="true">
                            <a href="{{ route('bac-si.index') }}" class="sub-icon {{Request::is('bac-si*') ? 'active' : '' }}"> Bác sĩ </a>
                        </li>
                        <li aria-haspopup="true">
                            <a href="{{ route('khung-gio.index') }}" class="sub-icon {{Request::is('khung-gio*') ? 'active' : '' }}"> Khung giờ </a>
                        </li>
                        <li aria-haspopup="true">
                            <a href="{{ route('tuychinh-khunggio.index') }}" class="sub-icon {{Request::is('tuychinh-khunggio*') ? 'active' : '' }}"> Tùy chỉnh khung giờ </a>
                        </li>
                        <li aria-haspopup="true">
                            <a href="{{ route('tuychinh-ngayoff.index') }}" class="sub-icon {{Request::is('tuychinh-ngayoff*') ? 'active' : '' }}">Tùy chỉnh ngày off </a>
                        </li>
                    </ul>
                </li>
                <li aria-haspopup="true">
                    <a href="{{ route('vac-xin.index') }}" class="sub-icon {{Request::is('vac-xin*') || Request::is('su-dung-vac-xin*') ? 'active' : '' }}">
                        <i class="side-menu__icon fe fe-monitor"></i> Vắc-xin <i class="side-menu__icon fe fe-chevron-down"></i>
                    </a>
                    <ul class="sub-menu">
                        <li aria-haspopup="true">
                            <a href="{{ route('su-dung-vac-xin.index') }}" class="sub-icon {{Request::is('su-dung-vac-xin*') ? 'active' : '' }}">Loại sử dụng vắc-xin </a>
                        </li>
                       
                    </ul>
                </li>
                <li aria-haspopup="true"><a href="{{ route('tuychinh-datlich.index') }}" class="sub-icon {{Request::is('tuychinh-datlich*') ? 'active' : '' }}"><i class="side-menu__icon fe fe-monitor"></i> Tùy chỉnh form đặt lịch </a>
                </li>
                <li aria-haspopup="true"><a href="{{ route('mau-tin-nhan.index') }}" class="sub-icon {{Request::is('mau-tin-nhan*') ? 'active' : '' }}"><i class="side-menu__icon fe fe-monitor"></i> Mẫu tin nhắn </a>
                </li>
                <li aria-haspopup="true"><a href="{{ route('activity-log.index') }}" class="sub-icon {{Request::is('activity-log*') ? 'active' : '' }}"><i class="side-menu__icon fe fe-monitor"></i> Activity log </a>
                </li>
                <li aria-haspopup="true"><a href="{{ route('export.index') }}" class="sub-icon {{Request::is('xuat-file*') ? 'active' : '' }}"><i class="side-menu__icon fe fe-monitor"></i> Xuất file </a>
                </li>

                @endcan
            </ul>
            
        </nav>
        <!--Nav end -->
    </div>
</div>