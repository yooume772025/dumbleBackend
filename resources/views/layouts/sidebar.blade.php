<aside class="app-sidebar shadow vh-100">
    <div class="sidebar-brand py-4 px-3 mb-3 text-center">
        <a href="{{ route('user.dashboard') }}" class="brand-link d-flex align-items-center justify-content-center">
            <span class="brand-text fw-bold text-white fs-4" id="sideh1">{{ env('APP_NAME') }}</span>
        </a>
    </div>
    <div class="sidebar-wrapper px-2">
        <nav class="side-outer">
            <ul class="nav sidebar-menu flex-column" data-lte-toggle="treeview" role="menu" data-accordion="false">
                <li class="nav-item mb-2">
                    <a href="{{ route('user.dashboard') }}"
                        class="nav-link {{ request()->routeIs('user.dashboard') ? 'active' : '' }}">
                        <i class="bi bi-house-door-fill me-2"></i>
                        <span>Dashboard</span>
                    </a>
                </li>

                <li
                    class="nav-item {{ request()->routeIs(['user.userbanned', 'user.reported-user', 'user.index']) ? 'menu-open' : '' }}">
                    <a href="#"
                        class="nav-link {{ request()->routeIs(['user.userbanned', 'user.reported-user', 'user.index']) ? 'active' : '' }}">
                        <i class="bi bi-person-fill"></i>
                        <p>
                            Manage Users
                            <i class="nav-arrow bi bi-chevron-right"></i>
                        </p>
                    </a>
                    <ul class="nav nav-treeview">
                        <li class="nav-item">
                            <a href="{{ route('user.index') }}"
                                class="nav-link {{ request()->routeIs('user.index') ? 'active' : '' }}">
                                <i class="nav-icon bi bi-person-lines-fill"></i>
                                <p>Users List</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('user.userbanned') }}"
                                class="nav-link {{ request()->routeIs('user.userbanned') ? 'active' : '' }}">
                                <i class="nav-icon bi bi-person-x-fill"></i>
                                <p>Ban or Suspended</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('user.reported-user') }}"
                                class="nav-link {{ request()->routeIs('user.reported-user') ? 'active' : '' }}">
                                <i class="nav-icon bi bi-flag-fill"></i>
                                <p>User Reports</p>
                            </a>
                        </li>
                    </ul>
                </li>

                <li
                    class="nav-item {{ request()->routeIs(['user.gender', 'user.sub-gender', 'user.height', 'user.relation', 'user.service', 'user.sub-service', 'user.caption', 'user.language', 'user.about', 'user.location', 'user.pronounce', 'user.work-out', 'user.job', 'user.exercise']) ? 'menu-open' : '' }}">
                    <a href="#"
                        class="nav-link {{ request()->routeIs(['user.gender', 'user.sub-gender', 'user.height', 'user.relation', 'user.service', 'user.sub-service', 'user.caption', 'user.language', 'user.about', 'user.location', 'user.pronounce', 'user.work-out', 'user.job', 'user.exercise']) ? 'active' : '' }}">
                        <i class="bi bi-wallet-fill"></i>
                        <p>
                            Masters
                            <i class="nav-arrow bi bi-chevron-right"></i>
                        </p>
                    </a>
                    <ul class="nav nav-treeview">
                        <li class="nav-item">
                            <a href="{{ route('user.gender') }}"
                                class="nav-link {{ request()->routeIs('user.gender') ? 'active' : '' }}">
                                <i class="nav-icon bi bi-gender-ambiguous"></i>
                                <p>Gender Master</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('user.sub-gender') }}"
                                class="nav-link {{ request()->routeIs('user.sub-gender') ? 'active' : '' }}">
                                <i class="nav-icon bi bi-gender-trans"></i>
                                <p>Sub-Gender Master</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('user.height') }}"
                                class="nav-link {{ request()->routeIs('user.height') ? 'active' : '' }}">
                                <i class="nav-icon bi bi-rulers"></i>
                                <p>Height Master</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('user.relation') }}"
                                class="nav-link {{ request()->routeIs('user.relation') ? 'active' : '' }}">
                                <i class="nav-icon bi bi-heart-fill"></i>
                                <p>Relationship Master</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('user.service') }}"
                                class="nav-link {{ request()->routeIs('user.service') ? 'active' : '' }}">
                                <i class="nav-icon bi bi-tools"></i>
                                <p>Service Master</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('user.sub-service') }}"
                                class="nav-link {{ request()->routeIs('user.sub-service') ? 'active' : '' }}">
                                <i class="nav-icon bi bi-wrench"></i>
                                <p>Sub Service Master</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('user.caption') }}"
                                class="nav-link {{ request()->routeIs('user.caption') ? 'active' : '' }}">
                                <i class="nav-icon bi bi-chat-quote-fill"></i>
                                <p>Caption Master</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('user.language') }}"
                                class="nav-link {{ request()->routeIs('user.language') ? 'active' : '' }}">
                                <i class="nav-icon bi bi-translate"></i>
                                <p>Language Master</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('user.about') }}"
                                class="nav-link {{ request()->routeIs('user.about') ? 'active' : '' }}">
                                <i class="nav-icon bi bi-info-circle-fill"></i>
                                <p>About Master</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('user.location') }}"
                                class="nav-link {{ request()->routeIs('user.location') ? 'active' : '' }}">
                                <i class="nav-icon bi bi-geo-alt-fill"></i>
                                <p>Location Master</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('user.pronounce') }}"
                                class="nav-link {{ request()->routeIs('user.pronounce') ? 'active' : '' }}">
                                <i class="nav-icon bi bi-mic-fill"></i>
                                <p>Pronounce Master</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('user.work-out') }}"
                                class="nav-link {{ request()->routeIs('user.work-out') ? 'active' : '' }}">
                                <i class="nav-icon bi bi-bicycle"></i>
                                <p>Workout</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('user.job') }}"
                                class="nav-link {{ request()->routeIs('user.job') ? 'active' : '' }}">
                                <i class="nav-icon bi bi-briefcase-fill"></i>
                                <p>Job</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('user.exercise') }}"
                                class="nav-link {{ request()->routeIs('user.exercise') ? 'active' : '' }}">
                                <i class="nav-icon bi bi-bar-chart-fill"></i>
                                <p>Exercise</p>
                            </a>
                        </li>
                    </ul>
                </li>

                <li class="nav-item">
                    <a href="{{ route('user.education') }}"
                        class="nav-link {{ request()->routeIs('user.education') ? 'active' : '' }}">
                        <i class="bi bi-mortarboard-fill"></i>
                        <p>Education</p>
                    </a>
                </li>

                <li class="nav-item {{ request()->routeIs('user.subscription') ? 'menu-open' : '' }}">
                    <a href="#"
                        class="nav-link {{ request()->routeIs('user.subscription') ? 'active' : '' }}">
                        <i class="bi bi-credit-card-fill"></i>
                        <p>
                            Subscriptions
                            <i class="nav-arrow bi bi-chevron-right"></i>
                        </p>
                    </a>
                    <ul class="nav nav-treeview">
                        <li class="nav-item">
                            <a href="{{ route('user.subscription') }}"
                                class="nav-link {{ request()->routeIs('user.subscription') ? 'active' : '' }}">
                                <i class="nav-icon bi bi-credit-card-2-front-fill"></i>
                                <p>Subscription</p>
                            </a>
                        </li>
                    </ul>
                </li>

                <li class="nav-item">
                    <a href="{{ route('user.settings') }}"
                        class="nav-link {{ request()->routeIs('user.settings') ? 'active' : '' }}">
                        <i class="bi bi-gear-fill"></i>
                        <p>Settings</p>
                    </a>
                </li>

                <li class="nav-item">
                    <a href="{{ route('user.user-subscription') }}"
                        class="nav-link {{ request()->routeIs('user.user-subscription') ? 'active' : '' }}">
                        <i class="bi bi-receipt-cutoff"></i>
                        <p>Transaction</p>
                    </a>
                </li>
            </ul>
        </nav>
    </div>
</aside>
