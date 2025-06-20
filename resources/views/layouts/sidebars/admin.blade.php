<div class="content-side content-side-full">
    <ul class="nav-main">
        <!-- Dashboard -->
        <li class="nav-main-item">
            <a class="nav-main-link {{ request()->routeIs('admin') ? 'active' : '' }}" href="{{ route('admin') }}">
                <i class="nav-main-link-icon fa fa-house-user"></i>
                <span class="nav-main-link-name">Dashboard</span>
            </a>
        </li>

        <!-- Level -->
        <li class="nav-main-item">
            <a class="nav-main-link nav-main-link-submenu {{ request()->routeIs('admin.*') ? 'active' : '' }}" data-toggle="submenu" href="#">
                <i class="nav-main-link-icon fa fa-list"></i>
                <span class="nav-main-link-name">Level</span>
            </a>
            <ul class="nav-main-submenu">
                <li class="nav-main-item">
                    <a class="nav-main-link" href="{{ route('admin.list.level') }}">
                        All Level
                    </a>
                </li>
                <li class="nav-main-item">
                    <a class="nav-main-link" href="{{ route('admin.create.level') }}">
                        Add New Level
                    </a>
                </li>
                  {{-- <li class="nav-main-item">
                    <a class="nav-main-link" href="{{ route('admin.level.items.all') }}">
                        Level Items
                    </a>
                </li> --}}
            </ul>
        </li>

        <!-- Manage Users -->
        <li class="nav-main-item">
            <a class="nav-main-link nav-main-link-submenu {{ request()->routeIs('admin.users.*') ? 'active' : '' }}" data-toggle="submenu" href="#">
                <i class="nav-main-link-icon fa fa-users"></i>
                <span class="nav-main-link-name">Manage Users</span>
            </a>
            <ul class="nav-main-submenu">
                <li class="nav-main-item">
                    <a class="nav-main-link" href="{{ route('admin.users.index') }}">
                        View All
                    </a>
                </li>
            </ul>
        </li>

        <!-- Manage Games -->
        <li class="nav-main-item">
            <a class="nav-main-link nav-main-link-submenu {{ request()->routeIs('admin.transactions.*') ? 'active' : '' }}" data-toggle="submenu" href="#">
                <i class="nav-main-link-icon fa fa-wallet"></i>
                <span class="nav-main-link-name">Transactions</span>
            </a>
            <ul class="nav-main-submenu">
                <li class="nav-main-item">
                    <a class="nav-main-link" href="{{ route('admin.transactions.all') }}">
                        View All
                    </a>
                </li>
            </ul>
        </li>

        <!-- Manage Questions -->
        {{-- <li class="nav-main-item">
            <a class="nav-main-link nav-main-link-submenu {{ request()->routeIs('admin.questions.*') ? 'active' : '' }}" data-toggle="submenu" href="#">
                <i class="nav-main-link-icon fa fa-question-circle"></i>
                <span class="nav-main-link-name">Manage Questions</span>
            </a>
            <ul class="nav-main-submenu">
                <li class="nav-main-item">
                    <a class="nav-main-link" href="{{ route('admin.questions.index') }}">
                        View All
                    </a>
                </li>
                <li class="nav-main-item">
                    <a class="nav-main-link" href="{{ route('admin.questions.create') }}">
                        Add New
                    </a>
                </li>
            </ul>
        </li> --}}

        <!-- Settings -->
        {{-- <li class="nav-main-item">
            <a class="nav-main-link {{ request()->routeIs('admin.settings') ? 'active' : '' }}" href="{{ route('admin.settings') }}">
                <i class="nav-main-link-icon fa fa-cogs"></i>
                <span class="nav-main-link-name">Settings</span>
            </a>
        </li> --}}

    </ul>
</div>


      {{--
              <li class="nav-main-item">
                <a class="nav-main-link" href="db_corporate.html">
                  <span class="nav-main-link-name">Corporate</span>
                </a>
              </li>
              <li class="nav-main-item">
                <a class="nav-main-link" href="db_minimal.html">
                  <span class="nav-main-link-name">Minimal</span>
                </a>
              </li>
              <li class="nav-main-item">
                <a class="nav-main-link" href="db_pop.html">
                  <span class="nav-main-link-name">Pop</span>
                </a>
              </li>
              <li class="nav-main-item">
                <a class="nav-main-link" href="db_medical.html">
                  <span class="nav-main-link-name">Medical</span>
                </a>
              </li>
            </ul>
          </li>
          <li class="nav-main-item">
            <a class="nav-main-link nav-main-link-submenu" data-toggle="submenu" aria-haspopup="true" aria-expanded="false" href="#">
              <span class="nav-main-link-name">Hosting</span>
            </a>
            <ul class="nav-main-submenu">
              <li class="nav-main-item">
                <a class="nav-main-link" href="be_pages_hosting_dashboard.html">
                  <span class="nav-main-link-name">Dashboard</span>
                </a>
              </li>
              <li class="nav-main-item">
                <a class="nav-main-link" href="be_pages_hosting_emails.html">
                  <span class="nav-main-link-name">Emails</span>
                </a>
              </li>
              <li class="nav-main-item">
                <a class="nav-main-link" href="be_pages_hosting_account.html">
                  <span class="nav-main-link-name">Account</span>
                </a>
              </li>
              <li class="nav-main-item">
                <a class="nav-main-link" href="be_pages_hosting_support.html">
                  <span class="nav-main-link-name">Support</span>
                </a>
              </li>
            </ul>
          </li>
          <li class="nav-main-item">
            <a class="nav-main-link nav-main-link-submenu" data-toggle="submenu" aria-haspopup="true" aria-expanded="false" href="#">
              <span class="nav-main-link-name">Real Estate</span>
            </a>
            <ul class="nav-main-submenu">
              <li class="nav-main-item">
                <a class="nav-main-link" href="be_pages_real_estate_dashboard.html">
                  <span class="nav-main-link-name">Dashboard</span>
                </a>
              </li>
              <li class="nav-main-item">
                <a class="nav-main-link" href="be_pages_real_estate_listing.html">
                  <span class="nav-main-link-name">Listing</span>
                </a>
              </li>
              <li class="nav-main-item">
                <a class="nav-main-link" href="be_pages_real_estate_listing_new.html">
                  <span class="nav-main-link-name">Add New Listing</span>
                </a>
              </li>
            </ul>
          </li>
          <li class="nav-main-item">
            <a class="nav-main-link nav-main-link-submenu" data-toggle="submenu" aria-haspopup="true" aria-expanded="false" href="#">
              <span class="nav-main-link-name">Crypto</span>
            </a>
            <ul class="nav-main-submenu">
              <li class="nav-main-item">
                <a class="nav-main-link" href="be_pages_crypto_dashboard.html">
                  <span class="nav-main-link-name">Dashboard</span>
                </a>
              </li>
              <li class="nav-main-item">
                <a class="nav-main-link" href="be_pages_crypto_buy_sell.html">
                  <span class="nav-main-link-name">Buy/Sell</span>
                </a>
              </li>
              <li class="nav-main-item">
                <a class="nav-main-link" href="be_pages_crypto_wallets.html">
                  <span class="nav-main-link-name">Wallets</span>
                </a>
              </li>
              <li class="nav-main-item">
                <a class="nav-main-link" href="be_pages_crypto_settings.html">
                  <span class="nav-main-link-name">Settings</span>
                </a>
              </li>
            </ul>
          </li>
          <li class="nav-main-item">
            <a class="nav-main-link nav-main-link-submenu" data-toggle="submenu" aria-haspopup="true" aria-expanded="false" href="#">
              <span class="nav-main-link-name">e-Commerce</span>
            </a>
            <ul class="nav-main-submenu">
              <li class="nav-main-item">
                <a class="nav-main-link" href="be_pages_ecom_dashboard.html">
                  <span class="nav-main-link-name">Dashboard</span>
                </a>
              </li>
              <li class="nav-main-item">
                <a class="nav-main-link" href="be_pages_ecom_orders.html">
                  <span class="nav-main-link-name">Orders</span>
                </a>
              </li>
              <li class="nav-main-item">
                <a class="nav-main-link" href="be_pages_ecom_order.html">
                  <span class="nav-main-link-name">Order</span>
                </a>
              </li>
              <li class="nav-main-item">
                <a class="nav-main-link" href="be_pages_ecom_products.html">
                  <span class="nav-main-link-name">Products</span>
                </a>
              </li>
              <li class="nav-main-item">
                <a class="nav-main-link" href="be_pages_ecom_product_edit.html">
                  <span class="nav-main-link-name">Product Edit</span>
                </a>
              </li>
              <li class="nav-main-item">
                <a class="nav-main-link" href="be_pages_ecom_customer.html">
                  <span class="nav-main-link-name">Customer</span>
                </a>
              </li>
            </ul>
          </li>
          <li class="nav-main-item">
            <a class="nav-main-link nav-main-link-submenu" data-toggle="submenu" aria-haspopup="true" aria-expanded="false" href="#">
              <span class="nav-main-link-name">e-Learning</span>
            </a>
            <ul class="nav-main-submenu">
              <li class="nav-main-item">
                <a class="nav-main-link" href="be_pages_elearning_courses.html">
                  <span class="nav-main-link-name">Courses</span>
                </a>
              </li>
              <li class="nav-main-item">
                <a class="nav-main-link" href="be_pages_elearning_course.html">
                  <span class="nav-main-link-name">Course</span>
                </a>
              </li>
              <li class="nav-main-item">
                <a class="nav-main-link" href="be_pages_elearning_lesson.html">
                  <span class="nav-main-link-name">Lesson</span>
                </a>
              </li>
            </ul>
          </li>
          <li class="nav-main-item">
            <a class="nav-main-link nav-main-link-submenu" data-toggle="submenu" aria-haspopup="true" aria-expanded="false" href="#">
              <span class="nav-main-link-name">Forum</span>
            </a>
            <ul class="nav-main-submenu">
              <li class="nav-main-item">
                <a class="nav-main-link" href="be_pages_forum_categories.html">
                  <span class="nav-main-link-name">Categories</span>
                </a>
              </li>
              <li class="nav-main-item">
                <a class="nav-main-link" href="be_pages_forum_topics.html">
                  <span class="nav-main-link-name">Topics</span>
                </a>
              </li>
              <li class="nav-main-item">
                <a class="nav-main-link" href="be_pages_forum_discussion.html">
                  <span class="nav-main-link-name">Discussion</span>
                </a>
              </li>
            </ul>
          </li>
          <li class="nav-main-item">
            <a class="nav-main-link nav-main-link-submenu" data-toggle="submenu" aria-haspopup="true" aria-expanded="false" href="#">
              <span class="nav-main-link-name">Boxed Backend</span>
            </a>
            <ul class="nav-main-submenu">
              <li class="nav-main-item">
                <a class="nav-main-link" href="bd_dashboard.html">
                  <span class="nav-main-link-name">Dashboard</span>
                </a>
              </li>
              <li class="nav-main-item">
                <a class="nav-main-link" href="bd_search.html">
                  <span class="nav-main-link-name">Search</span>
                </a>
              </li>
              <li class="nav-main-item">
                <a class="nav-main-link" href="bd_variations_hero_simple_1.html">
                  <span class="nav-main-link-name">Hero Simple 1</span>
                </a>
              </li>
              <li class="nav-main-item">
                <a class="nav-main-link" href="bd_variations_hero_simple_2.html">
                  <span class="nav-main-link-name">Hero Simple 2</span>
                </a>
              </li>
              <li class="nav-main-item">
                <a class="nav-main-link" href="bd_variations_hero_simple_3.html">
                  <span class="nav-main-link-name">Hero Simple 3</span>
                </a>
              </li>
              <li class="nav-main-item">
                <a class="nav-main-link" href="bd_variations_hero_simple_4.html">
                  <span class="nav-main-link-name">Hero Simple 4</span>
                </a>
              </li>
              <li class="nav-main-item">
                <a class="nav-main-link" href="bd_variations_hero_image_1.html">
                  <span class="nav-main-link-name">Hero Image 1</span>
                </a>
              </li>
              <li class="nav-main-item">
                <a class="nav-main-link" href="bd_variations_hero_image_2.html">
                  <span class="nav-main-link-name">Hero Image 2</span>
                </a>
              </li>
              <li class="nav-main-item">
                <a class="nav-main-link" href="bd_variations_hero_image_3.html">
                  <span class="nav-main-link-name">Hero Image 3</span>
                </a>
              </li>
              <li class="nav-main-item">
                <a class="nav-main-link" href="bd_variations_hero_image_4.html">
                  <span class="nav-main-link-name">Hero Image 4</span>
                </a>
              </li>
              <li class="nav-main-item">
                <a class="nav-main-link" href="bd_variations_hero_video_1.html">
                  <span class="nav-main-link-name">Hero Video 1</span>
                </a>
              </li>
              <li class="nav-main-item">
                <a class="nav-main-link" href="bd_variations_hero_video_2.html">
                  <span class="nav-main-link-name">Hero Video 2</span>
                </a>
              </li>
            </ul>
          </li>
        </ul>
      </li>
      <li class="nav-main-heading">User Interface</li>
      <li class="nav-main-item">
        <a class="nav-main-link nav-main-link-submenu" data-toggle="submenu" aria-haspopup="true" aria-expanded="false" href="#">
          <i class="nav-main-link-icon fa fa-grip-vertical"></i>
          <span class="nav-main-link-name">Blocks</span>
        </a>
        <ul class="nav-main-submenu">
          <li class="nav-main-item">
            <a class="nav-main-link" href="be_blocks_styles.html">
              <span class="nav-main-link-name">Styles</span>
            </a>
          </li>
          <li class="nav-main-item">
            <a class="nav-main-link" href="be_blocks_options.html">
              <span class="nav-main-link-name">Options</span>
            </a>
          </li>
          <li class="nav-main-item">
            <a class="nav-main-link" href="be_blocks_forms.html">
              <span class="nav-main-link-name">Forms</span>
            </a>
          </li>
          <li class="nav-main-item">
            <a class="nav-main-link" href="be_blocks_themed.html">
              <span class="nav-main-link-name">Themed</span>
            </a>
          </li>
          <li class="nav-main-item">
            <a class="nav-main-link" href="be_blocks_api.html">
              <span class="nav-main-link-name">API</span>
            </a>
          </li>
        </ul>
      </li>
      <li class="nav-main-item">
        <a class="nav-main-link nav-main-link-submenu" data-toggle="submenu" aria-haspopup="true" aria-expanded="false" href="#">
          <i class="nav-main-link-icon fa fa-pencil-ruler"></i>
          <span class="nav-main-link-name">Widgets</span>
        </a>
        <ul class="nav-main-submenu">
          <li class="nav-main-item">
            <a class="nav-main-link" href="be_widgets_tiles.html">
              <span class="nav-main-link-name">Tiles</span>
            </a>
          </li>
          <li class="nav-main-item">
            <a class="nav-main-link" href="be_widgets_users.html">
              <span class="nav-main-link-name">Users</span>
            </a>
          </li>
          <li class="nav-main-item">
            <a class="nav-main-link" href="be_widgets_stats.html">
              <span class="nav-main-link-name">Statistics</span>
            </a>
          </li>
          <li class="nav-main-item">
            <a class="nav-main-link" href="be_widgets_media.html">
              <span class="nav-main-link-name">Media</span>
            </a>
          </li>
          <li class="nav-main-item">
            <a class="nav-main-link" href="be_widgets_blog.html">
              <span class="nav-main-link-name">Blog</span>
            </a>
          </li>
          <li class="nav-main-item">
            <a class="nav-main-link" href="be_widgets_projects.html">
              <span class="nav-main-link-name">Projects</span>
            </a>
          </li>
        </ul>
      </li>
      <li class="nav-main-item">
        <a class="nav-main-link nav-main-link-submenu" data-toggle="submenu" aria-haspopup="true" aria-expanded="false" href="#">
          <i class="nav-main-link-icon fa fa-layer-group"></i>
          <span class="nav-main-link-name">Elements</span>
        </a>
        <ul class="nav-main-submenu">
          <li class="nav-main-item">
            <a class="nav-main-link" href="be_ui_grid.html">
              <span class="nav-main-link-name">Grid</span>
            </a>
          </li>
          <li class="nav-main-item">
            <a class="nav-main-link" href="be_ui_icons.html">
              <span class="nav-main-link-name">Icons</span>
            </a>
          </li>
          <li class="nav-main-item">
            <a class="nav-main-link" href="be_ui_typography.html">
              <span class="nav-main-link-name">Typography</span>
            </a>
          </li>
          <li class="nav-main-item">
            <a class="nav-main-link" href="be_ui_buttons.html">
              <span class="nav-main-link-name">Buttons</span>
            </a>
          </li>
          <li class="nav-main-item">
            <a class="nav-main-link" href="be_ui_buttons_groups.html">
              <span class="nav-main-link-name">Button Groups</span>
            </a>
          </li>
          <li class="nav-main-item">
            <a class="nav-main-link" href="be_ui_dropdowns.html">
              <span class="nav-main-link-name">Dropdowns</span>
            </a>
          </li>
          <li class="nav-main-item">
            <a class="nav-main-link" href="be_ui_navigation.html">
              <span class="nav-main-link-name">Navigation</span>
            </a>
          </li>
          <li class="nav-main-item">
            <a class="nav-main-link" href="be_ui_navigation_horizontal.html">
              <span class="nav-main-link-name">Horizontal Navigation</span>
            </a>
          </li>
          <li class="nav-main-item">
            <a class="nav-main-link" href="be_ui_tabs.html">
              <span class="nav-main-link-name">Tabs</span>
            </a>
          </li>
          <li class="nav-main-item">
            <a class="nav-main-link" href="be_ui_alerts.html">
              <span class="nav-main-link-name">Alerts</span>
            </a>
          </li>
          <li class="nav-main-item">
            <a class="nav-main-link" href="be_ui_progress.html">
              <span class="nav-main-link-name">Progress</span>
            </a>
          </li>
          <li class="nav-main-item">
            <a class="nav-main-link" href="be_ui_tooltips.html">
              <span class="nav-main-link-name">Tooltips</span>
            </a>
          </li>
          <li class="nav-main-item">
            <a class="nav-main-link" href="be_ui_popovers.html">
              <span class="nav-main-link-name">Popovers</span>
            </a>
          </li>
          <li class="nav-main-item">
            <a class="nav-main-link" href="be_ui_modals.html">
              <span class="nav-main-link-name">Modals</span>
            </a>
          </li>
          <li class="nav-main-item">
            <a class="nav-main-link" href="be_ui_images.html">
              <span class="nav-main-link-name">Images</span>
            </a>
          </li>
          <li class="nav-main-item">
            <a class="nav-main-link" href="be_ui_animations.html">
              <span class="nav-main-link-name">Animations</span>
            </a>
          </li>
          <li class="nav-main-item">
            <a class="nav-main-link" href="be_ui_ribbons.html">
              <span class="nav-main-link-name">Ribbons</span>
            </a>
          </li>
          <li class="nav-main-item">
            <a class="nav-main-link" href="be_ui_steps.html">
              <span class="nav-main-link-name">Steps</span>
            </a>
          </li>
          <li class="nav-main-item">
            <a class="nav-main-link" href="be_ui_timeline.html">
              <span class="nav-main-link-name">Timeline</span>
            </a>
          </li>
          <li class="nav-main-item">
            <a class="nav-main-link" href="be_ui_accordion.html">
              <span class="nav-main-link-name">Accordion</span>
            </a>
          </li>
          <li class="nav-main-item">
            <a class="nav-main-link" href="be_ui_color_themes.html">
              <span class="nav-main-link-name">Color Themes</span>
            </a>
          </li>
        </ul>
      </li>
      <li class="nav-main-item">
        <a class="nav-main-link nav-main-link-submenu" data-toggle="submenu" aria-haspopup="true" aria-expanded="false" href="#">
          <i class="nav-main-link-icon fa fa-list-alt"></i>
          <span class="nav-main-link-name">Tables</span>
        </a>
        <ul class="nav-main-submenu">
          <li class="nav-main-item">
            <a class="nav-main-link" href="be_tables_styles.html">
              <span class="nav-main-link-name">Styles</span>
            </a>
          </li>
          <li class="nav-main-item">
            <a class="nav-main-link" href="be_tables_responsive.html">
              <span class="nav-main-link-name">Responsive</span>
            </a>
          </li>
          <li class="nav-main-item">
            <a class="nav-main-link" href="be_tables_helpers.html">
              <span class="nav-main-link-name">Helpers</span>
            </a>
          </li>
          <li class="nav-main-item">
            <a class="nav-main-link" href="be_tables_datatables.html">
              <span class="nav-main-link-name">DataTables</span>
            </a>
          </li>
        </ul>
      </li>
      <li class="nav-main-item">
        <a class="nav-main-link nav-main-link-submenu" data-toggle="submenu" aria-haspopup="true" aria-expanded="false" href="#">
          <i class="nav-main-link-icon fa fa-edit"></i>
          <span class="nav-main-link-name">Forms</span>
        </a>
        <ul class="nav-main-submenu">
          <li class="nav-main-item">
            <a class="nav-main-link" href="be_forms_elements.html">
              <span class="nav-main-link-name">Elements</span>
            </a>
          </li>
          <li class="nav-main-item">
            <a class="nav-main-link" href="be_forms_layouts.html">
              <span class="nav-main-link-name">Layouts</span>
            </a>
          </li>
          <li class="nav-main-item">
            <a class="nav-main-link" href="be_forms_input_groups.html">
              <span class="nav-main-link-name">Input Groups</span>
            </a>
          </li>
          <li class="nav-main-item">
            <a class="nav-main-link" href="be_forms_plugins.html">
              <span class="nav-main-link-name">Plugins</span>
            </a>
          </li>
          <li class="nav-main-item">
            <a class="nav-main-link" href="be_forms_editors.html">
              <span class="nav-main-link-name">Editors</span>
            </a>
          </li>
          <li class="nav-main-item">
            <a class="nav-main-link nav-main-link-submenu" data-toggle="submenu" aria-haspopup="true" aria-expanded="false" href="#">
              <span class="nav-main-link-name">CKEditor 5</span>
            </a>
            <ul class="nav-main-submenu">
              <li class="nav-main-item">
                <a class="nav-main-link" href="be_forms_ckeditor5_classic.html">
                  <span class="nav-main-link-name">Classic</span>
                </a>
              </li>
              <li class="nav-main-item">
                <a class="nav-main-link" href="be_forms_ckeditor5_inline.html">
                  <span class="nav-main-link-name">Inline</span>
                </a>
              </li>
            </ul>
          </li>
          <li class="nav-main-item">
            <a class="nav-main-link" href="be_forms_validation.html">
              <span class="nav-main-link-name">Validation</span>
            </a>
          </li>
          <li class="nav-main-item">
            <a class="nav-main-link" href="be_forms_premade.html">
              <span class="nav-main-link-name">Pre-made</span>
            </a>
          </li>
        </ul>
      </li>
      <li class="nav-main-heading">Build</li>
      <li class="nav-main-item">
        <a class="nav-main-link nav-main-link-submenu" data-toggle="submenu" aria-haspopup="true" aria-expanded="false" href="#">
          <i class="nav-main-link-icon fa fa-vector-square"></i>
          <span class="nav-main-link-name">Layout</span>
        </a>
        <ul class="nav-main-submenu">
          <li class="nav-main-item">
            <a class="nav-main-link nav-main-link-submenu" data-toggle="submenu" aria-haspopup="true" aria-expanded="false" href="#">
              <span class="nav-main-link-name">General</span>
            </a>
            <ul class="nav-main-submenu">
              <li class="nav-main-item">
                <a class="nav-main-link" href="be_layout_default.html">
                  <span class="nav-main-link-name">Default</span>
                </a>
              </li>
              <li class="nav-main-item">
                <a class="nav-main-link" href="be_layout_flipped.html">
                  <span class="nav-main-link-name">Flipped</span>
                </a>
              </li>
              <li class="nav-main-item">
                <a class="nav-main-link" href="be_layout_native_scrolling.html">
                  <span class="nav-main-link-name">Native Scrolling</span>
                </a>
              </li>
            </ul>
          </li>
          <li class="nav-main-item">
            <a class="nav-main-link nav-main-link-submenu" data-toggle="submenu" aria-haspopup="true" aria-expanded="false" href="#">
              <span class="nav-main-link-name">Header</span>
            </a>
            <ul class="nav-main-submenu">
              <li class="nav-main-item">
                <a class="nav-main-link nav-main-link-submenu" data-toggle="submenu" aria-haspopup="true" aria-expanded="false" href="#">
                  <span class="nav-main-link-name">Static</span>
                </a>
                <ul class="nav-main-submenu">
                  <li class="nav-main-item">
                    <a class="nav-main-link" href="be_layout_header_modern.html">
                      <span class="nav-main-link-name">Modern</span>
                    </a>
                  </li>
                  <li class="nav-main-item">
                    <a class="nav-main-link" href="be_layout_header_classic.html">
                      <span class="nav-main-link-name">Classic</span>
                    </a>
                  </li>
                  <li class="nav-main-item">
                    <a class="nav-main-link" href="be_layout_header_classic_dark.html">
                      <span class="nav-main-link-name">Classic Dark</span>
                    </a>
                  </li>
                  <li class="nav-main-item">
                    <a class="nav-main-link" href="be_layout_header_glass.html">
                      <span class="nav-main-link-name">Glass</span>
                    </a>
                  </li>
                  <li class="nav-main-item">
                    <a class="nav-main-link" href="be_layout_header_glass_dark.html">
                      <span class="nav-main-link-name">Glass Dark</span>
                    </a>
                  </li>
                </ul>
              </li>
              <li class="nav-main-item">
                <a class="nav-main-link nav-main-link-submenu" data-toggle="submenu" aria-haspopup="true" aria-expanded="false" href="#">
                  <span class="nav-main-link-name">Fixed</span>
                </a>
                <ul class="nav-main-submenu">
                  <li class="nav-main-item">
                    <a class="nav-main-link" href="be_layout_header_fixed_modern.html">
                      <span class="nav-main-link-name">Modern</span>
                    </a>
                  </li>
                  <li class="nav-main-item">
                    <a class="nav-main-link" href="be_layout_header_fixed_classic.html">
                      <span class="nav-main-link-name">Classic</span>
                    </a>
                  </li>
                  <li class="nav-main-item">
                    <a class="nav-main-link" href="be_layout_header_fixed_classic_dark.html">
                      <span class="nav-main-link-name">Classic Dark</span>
                    </a>
                  </li>
                  <li class="nav-main-item">
                    <a class="nav-main-link" href="be_layout_header_fixed_glass.html">
                      <span class="nav-main-link-name">Glass</span>
                    </a>
                  </li>
                  <li class="nav-main-item">
                    <a class="nav-main-link" href="be_layout_header_fixed_glass_dark.html">
                      <span class="nav-main-link-name">Glass Dark</span>
                    </a>
                  </li>
                </ul>
              </li>
            </ul>
          </li>
          <li class="nav-main-item">
            <a class="nav-main-link nav-main-link-submenu" data-toggle="submenu" aria-haspopup="true" aria-expanded="false" href="#">
              <span class="nav-main-link-name">Sidebar</span>
            </a>
            <ul class="nav-main-submenu">
              <li class="nav-main-item">
                <a class="nav-main-link" href="be_layout_sidebar_dark.html">
                  <span class="nav-main-link-name">Dark</span>
                </a>
              </li>
              <li class="nav-main-item">
                <a class="nav-main-link" href="be_layout_sidebar_hidden.html">
                  <span class="nav-main-link-name">Hidden</span>
                </a>
              </li>
              <li class="nav-main-item">
                <a class="nav-main-link" href="be_layout_sidebar_mini.html">
                  <span class="nav-main-link-name">Mini</span>
                </a>
              </li>
            </ul>
          </li>
          <li class="nav-main-item">
            <a class="nav-main-link nav-main-link-submenu" data-toggle="submenu" aria-haspopup="true" aria-expanded="false" href="#">
              <span class="nav-main-link-name">Side Overlay</span>
            </a>
            <ul class="nav-main-submenu">
              <li class="nav-main-item">
                <a class="nav-main-link" href="be_layout_side_overlay_visible.html">
                  <span class="nav-main-link-name">Visible</span>
                </a>
              </li>
              <li class="nav-main-item">
                <a class="nav-main-link" href="be_layout_side_overlay_hoverable.html">
                  <span class="nav-main-link-name">Hoverable</span>
                </a>
              </li>
              <li class="nav-main-item">
                <a class="nav-main-link" href="be_layout_side_overlay_no_page_overlay.html">
                  <span class="nav-main-link-name">No Page Overlay</span>
                </a>
              </li>
            </ul>
          </li>
          <li class="nav-main-item">
            <a class="nav-main-link nav-main-link-submenu" data-toggle="submenu" aria-haspopup="true" aria-expanded="false" href="#">
              <span class="nav-main-link-name">Main Content</span>
            </a>
            <ul class="nav-main-submenu">
              <li class="nav-main-item">
                <a class="nav-main-link" href="be_layout_content_boxed.html">
                  <span class="nav-main-link-name">Boxed</span>
                </a>
              </li>
              <li class="nav-main-item">
                <a class="nav-main-link" href="be_layout_content_narrow.html">
                  <span class="nav-main-link-name">Narrow</span>
                </a>
              </li>
              <li class="nav-main-item">
                <a class="nav-main-link" href="be_layout_content_full_width.html">
                  <span class="nav-main-link-name">Full Width</span>
                </a>
              </li>
            </ul>
          </li>
          <li class="nav-main-item">
            <a class="nav-main-link nav-main-link-submenu" data-toggle="submenu" aria-haspopup="true" aria-expanded="false" href="#">
              <span class="nav-main-link-name">Hero</span>
            </a>
            <ul class="nav-main-submenu">
              <li class="nav-main-item">
                <a class="nav-main-link" href="be_layout_hero_color.html">
                  <span class="nav-main-link-name">Color</span>
                </a>
              </li>
              <li class="nav-main-item">
                <a class="nav-main-link" href="be_layout_hero_bubbles.html">
                  <span class="nav-main-link-name">Bubbles</span>
                </a>
              </li>
              <li class="nav-main-item">
                <a class="nav-main-link" href="be_layout_hero_image.html">
                  <span class="nav-main-link-name">Image</span>
                </a>
              </li>
              <li class="nav-main-item">
                <a class="nav-main-link" href="be_layout_hero_video.html">
                  <span class="nav-main-link-name">Video</span>
                </a>
              </li>
            </ul>
          </li>
          <li class="nav-main-item">
            <a class="nav-main-link" href="be_layout_api.html">
              <span class="nav-main-link-name">API</span>
            </a>
          </li>
        </ul>
      </li>
      <li class="nav-main-item">
        <a class="nav-main-link nav-main-link-submenu" data-toggle="submenu" aria-haspopup="true" aria-expanded="false" href="#">
          <i class="nav-main-link-icon fa fa-cogs"></i>
          <span class="nav-main-link-name">Components</span>
        </a>
        <ul class="nav-main-submenu">
          <li class="nav-main-item">
            <a class="nav-main-link" href="be_comp_charts.html">
              <span class="nav-main-link-name">Charts</span>
            </a>
          </li>
          <li class="nav-main-item">
            <a class="nav-main-link" href="be_comp_onboarding.html">
              <span class="nav-main-link-name">Onboarding</span>
            </a>
          </li>
          <li class="nav-main-item">
            <a class="nav-main-link" href="be_comp_loaders.html">
              <span class="nav-main-link-name">Loaders</span>
            </a>
          </li>
          <li class="nav-main-item">
            <a class="nav-main-link" href="be_comp_dialogs.html">
              <span class="nav-main-link-name">Dialogs</span>
            </a>
          </li>
          <li class="nav-main-item">
            <a class="nav-main-link" href="be_comp_notifications.html">
              <span class="nav-main-link-name">Notifications</span>
            </a>
          </li>
          <li class="nav-main-item">
            <a class="nav-main-link" href="be_comp_nestable.html">
              <span class="nav-main-link-name">Nestable</span>
            </a>
          </li>
          <li class="nav-main-item">
            <a class="nav-main-link" href="be_comp_gallery.html">
              <span class="nav-main-link-name">Gallery</span>
            </a>
          </li>
          <li class="nav-main-item">
            <a class="nav-main-link" href="be_comp_sliders.html">
              <span class="nav-main-link-name">Sliders</span>
            </a>
          </li>
          <li class="nav-main-item">
            <a class="nav-main-link" href="be_comp_carousel.html">
              <span class="nav-main-link-name">Carousel</span>
            </a>
          </li>
          <li class="nav-main-item">
            <a class="nav-main-link" href="be_comp_offcanvas.html">
              <span class="nav-main-link-name">Offcanvas</span>
            </a>
          </li>
          <li class="nav-main-item">
            <a class="nav-main-link" href="be_comp_rating.html">
              <span class="nav-main-link-name">Rating</span>
            </a>
          </li>
          <li class="nav-main-item">
            <a class="nav-main-link" href="be_comp_appear.html">
              <span class="nav-main-link-name">Appear</span>
            </a>
          </li>
          <li class="nav-main-item">
            <a class="nav-main-link" href="be_comp_calendar.html">
              <span class="nav-main-link-name">Calendar</span>
            </a>
          </li>
          <li class="nav-main-item">
            <a class="nav-main-link" href="be_comp_image_cropper.html">
              <span class="nav-main-link-name">Image Cropper</span>
            </a>
          </li>
          <li class="nav-main-item">
            <a class="nav-main-link" href="be_comp_maps_vector.html">
              <span class="nav-main-link-name">Vector Maps</span>
            </a>
          </li>
          <li class="nav-main-item">
            <a class="nav-main-link" href="be_comp_syntax_highlighting.html">
              <span class="nav-main-link-name">Syntax Highlighting</span>
            </a>
          </li>
        </ul>
      </li>
      <li class="nav-main-item">
        <a class="nav-main-link nav-main-link-submenu" data-toggle="submenu" aria-haspopup="true" aria-expanded="false" href="#">
          <i class="nav-main-link-icon fa fa-puzzle-piece"></i>
          <span class="nav-main-link-name">Main Menu</span>
        </a>
        <ul class="nav-main-submenu">
          <li class="nav-main-item">
            <a class="nav-main-link" href="#">
              <span class="nav-main-link-name">Link 1-1</span>
            </a>
          </li>
          <li class="nav-main-item">
            <a class="nav-main-link" href="#">
              <span class="nav-main-link-name">Link 1-2</span>
            </a>
          </li>
          <li class="nav-main-item">
            <a class="nav-main-link nav-main-link-submenu" data-toggle="submenu" aria-haspopup="true" aria-expanded="false" href="#">
              <span class="nav-main-link-name">Sub Level 2</span>
            </a>
            <ul class="nav-main-submenu">
              <li class="nav-main-item">
                <a class="nav-main-link" href="#">
                  <span class="nav-main-link-name">Link 2-1</span>
                </a>
              </li>
              <li class="nav-main-item">
                <a class="nav-main-link" href="#">
                  <span class="nav-main-link-name">Link 2-2</span>
                </a>
              </li>
              <li class="nav-main-item">
                <a class="nav-main-link nav-main-link-submenu" data-toggle="submenu" aria-haspopup="true" aria-expanded="false" href="#">
                  <span class="nav-main-link-name">Sub Level 3</span>
                </a>
                <ul class="nav-main-submenu">
                  <li class="nav-main-item">
                    <a class="nav-main-link" href="#">
                      <span class="nav-main-link-name">Link 3-1</span>
                    </a>
                  </li>
                  <li class="nav-main-item">
                    <a class="nav-main-link" href="#">
                      <span class="nav-main-link-name">Link 3-2</span>
                    </a>
                  </li>
                </ul>
              </li>
            </ul>
          </li>
        </ul>
      </li>
      <li class="nav-main-heading">Pages</li>
      <li class="nav-main-item">
        <a class="nav-main-link nav-main-link-submenu" data-toggle="submenu" aria-haspopup="true" aria-expanded="false" href="#">
          <i class="nav-main-link-icon fa fa-globe-americas"></i>
          <span class="nav-main-link-name">Generic</span>
        </a>
        <ul class="nav-main-submenu">
          <li class="nav-main-item">
            <a class="nav-main-link" href="be_pages_generic_blank.html">
              <span class="nav-main-link-name">Blank</span>
            </a>
          </li>
          <li class="nav-main-item">
            <a class="nav-main-link" href="be_pages_generic_blank_block.html">
              <span class="nav-main-link-name">Blank (Block)</span>
            </a>
          </li>
          <li class="nav-main-item">
            <a class="nav-main-link" href="be_pages_generic_blank_breadcrumb.html">
              <span class="nav-main-link-name">Blank (Breadcrumb)</span>
            </a>
          </li>
          <li class="nav-main-item">
            <a class="nav-main-link" href="be_pages_generic_search.html">
              <span class="nav-main-link-name">Search</span>
            </a>
          </li>
          <li class="nav-main-item">
            <a class="nav-main-link" href="be_pages_generic_profile.html">
              <span class="nav-main-link-name">Profile</span>
            </a>
          </li>
          <li class="nav-main-item">
            <a class="nav-main-link" href="be_pages_generic_profile_edit.html">
              <span class="nav-main-link-name">Profile Edit</span>
            </a>
          </li>
          <li class="nav-main-item">
            <a class="nav-main-link" href="be_pages_generic_inbox.html">
              <span class="nav-main-link-name">Inbox</span>
            </a>
          </li>
          <li class="nav-main-item">
            <a class="nav-main-link" href="be_pages_generic_invoice.html">
              <span class="nav-main-link-name">Invoice</span>
            </a>
          </li>
          <li class="nav-main-item">
            <a class="nav-main-link" href="be_pages_generic_faq.html">
              <span class="nav-main-link-name">FAQ</span>
            </a>
          </li>
          <li class="nav-main-item">
            <a class="nav-main-link" href="be_pages_generic_blog.html">
              <span class="nav-main-link-name">Blog</span>
            </a>
          </li>
          <li class="nav-main-item">
            <a class="nav-main-link" href="be_pages_generic_story.html">
              <span class="nav-main-link-name">Story</span>
            </a>
          </li>
          <li class="nav-main-item">
            <a class="nav-main-link" href="be_pages_generic_project_list.html">
              <span class="nav-main-link-name">Project List</span>
            </a>
          </li>
          <li class="nav-main-item">
            <a class="nav-main-link" href="be_pages_generic_project.html">
              <span class="nav-main-link-name">Project</span>
            </a>
          </li>
          <li class="nav-main-item">
            <a class="nav-main-link" href="be_pages_generic_pricing_plans.html">
              <span class="nav-main-link-name">Pricing Plans</span>
            </a>
          </li>
          <li class="nav-main-item">
            <a class="nav-main-link" href="be_pages_generic_upgrade_plan.html">
              <span class="nav-main-link-name">Upgrade Plan</span>
            </a>
          </li>
          <li class="nav-main-item">
            <a class="nav-main-link" href="be_pages_generic_team.html">
              <span class="nav-main-link-name">Team</span>
            </a>
          </li>
          <li class="nav-main-item">
            <a class="nav-main-link" href="be_pages_generic_contact.html">
              <span class="nav-main-link-name">Contact</span>
            </a>
          </li>
          <li class="nav-main-item">
            <a class="nav-main-link" href="be_pages_generic_todo.html">
              <span class="nav-main-link-name">Todo</span>
            </a>
          </li>
          <li class="nav-main-item">
            <a class="nav-main-link" href="be_pages_sidebar_mini_nav.html">
              <span class="nav-main-link-name">Sidebar with Mini Nav</span>
            </a>
          </li>
          <li class="nav-main-item">
            <a class="nav-main-link" href="op_coming_soon.html">
              <span class="nav-main-link-name">Coming Soon</span>
            </a>
          </li>
          <li class="nav-main-item">
            <a class="nav-main-link" href="op_maintenance.html">
              <span class="nav-main-link-name">Maintenance</span>
            </a>
          </li>
          <li class="nav-main-item">
            <a class="nav-main-link" href="op_status.html">
              <span class="nav-main-link-name">Status</span>
            </a>
          </li>
          <li class="nav-main-item">
            <a class="nav-main-link" href="op_installation.html">
              <span class="nav-main-link-name">Installation</span>
            </a>
          </li>
          <li class="nav-main-item">
            <a class="nav-main-link" href="op_checkout.html">
              <span class="nav-main-link-name">Checkout</span>
            </a>
          </li>
        </ul>
      </li>
      <li class="nav-main-item">
        <a class="nav-main-link nav-main-link-submenu" data-toggle="submenu" aria-haspopup="true" aria-expanded="false" href="#">
          <i class="nav-main-link-icon fa fa-user-lock"></i>
          <span class="nav-main-link-name">Authentication</span>
        </a>
        <ul class="nav-main-submenu">
          <li class="nav-main-item">
            <a class="nav-main-link" href="be_pages_auth_all.html">
              <span class="nav-main-link-name">All</span>
            </a>
          </li>
          <li class="nav-main-item">
            <a class="nav-main-link" href="op_auth_signin.html">
              <span class="nav-main-link-name">Sign In</span>
            </a>
          </li>
          <li class="nav-main-item">
            <a class="nav-main-link" href="op_auth_signin2.html">
              <span class="nav-main-link-name">Sign In 2</span>
            </a>
          </li>
          <li class="nav-main-item">
            <a class="nav-main-link" href="op_auth_signin3.html">
              <span class="nav-main-link-name">Sign In 3</span>
            </a>
          </li>
          <li class="nav-main-item">
            <a class="nav-main-link" href="op_auth_signup.html">
              <span class="nav-main-link-name">Sign Up</span>
            </a>
          </li>
          <li class="nav-main-item">
            <a class="nav-main-link" href="op_auth_signup2.html">
              <span class="nav-main-link-name">Sign Up 2</span>
            </a>
          </li>
          <li class="nav-main-item">
            <a class="nav-main-link" href="op_auth_signup3.html">
              <span class="nav-main-link-name">Sign Up 3</span>
            </a>
          </li>
          <li class="nav-main-item">
            <a class="nav-main-link" href="op_auth_lock.html">
              <span class="nav-main-link-name">Lock Screen</span>
            </a>
          </li>
          <li class="nav-main-item">
            <a class="nav-main-link" href="op_auth_lock2.html">
              <span class="nav-main-link-name">Lock Screen 2</span>
            </a>
          </li>
          <li class="nav-main-item">
            <a class="nav-main-link" href="op_auth_lock3.html">
              <span class="nav-main-link-name">Lock Screen 3</span>
            </a>
          </li>
          <li class="nav-main-item">
            <a class="nav-main-link" href="op_auth_reminder.html">
              <span class="nav-main-link-name">Pass Reminder</span>
            </a>
          </li>
          <li class="nav-main-item">
            <a class="nav-main-link" href="op_auth_reminder2.html">
              <span class="nav-main-link-name">Pass Reminder 2</span>
            </a>
          </li>
          <li class="nav-main-item">
            <a class="nav-main-link" href="op_auth_reminder3.html">
              <span class="nav-main-link-name">Pass Reminder 3</span>
            </a>
          </li>
          <li class="nav-main-item">
            <a class="nav-main-link" href="op_auth_two_factor.html">
              <span class="nav-main-link-name">Two Factor</span>
            </a>
          </li>
          <li class="nav-main-item">
            <a class="nav-main-link" href="op_auth_two_factor2.html">
              <span class="nav-main-link-name">Two Factor 2</span>
            </a>
          </li>
          <li class="nav-main-item">
            <a class="nav-main-link" href="op_auth_two_factor3.html">
              <span class="nav-main-link-name">Two Factor 3</span>
            </a>
          </li>
        </ul>
      </li>
      <li class="nav-main-item">
        <a class="nav-main-link nav-main-link-submenu" data-toggle="submenu" aria-haspopup="true" aria-expanded="false" href="#">
          <i class="nav-main-link-icon fa fa-flag"></i>
          <span class="nav-main-link-name">Error</span>
        </a>
        <ul class="nav-main-submenu">
          <li class="nav-main-item">
            <a class="nav-main-link" href="be_pages_error_all.html">
              <span class="nav-main-link-name">All</span>
            </a>
          </li>
          <li class="nav-main-item">
            <a class="nav-main-link" href="op_error_400.html">
              <span class="nav-main-link-name">400</span>
            </a>
          </li>
          <li class="nav-main-item">
            <a class="nav-main-link" href="op_error_401.html">
              <span class="nav-main-link-name">401</span>
            </a>
          </li>
          <li class="nav-main-item">
            <a class="nav-main-link" href="op_error_403.html">
              <span class="nav-main-link-name">403</span>
            </a>
          </li>
          <li class="nav-main-item">
            <a class="nav-main-link" href="op_error_404.html">
              <span class="nav-main-link-name">404</span>
            </a>
          </li>
          <li class="nav-main-item">
            <a class="nav-main-link" href="op_error_500.html">
              <span class="nav-main-link-name">500</span>
            </a>
          </li>
          <li class="nav-main-item">
            <a class="nav-main-link" href="op_error_503.html">
              <span class="nav-main-link-name">503</span>
            </a>
          </li>
        </ul>
      </li>
      <li class="nav-main-item">
        <a class="nav-main-link nav-main-link-submenu" data-toggle="submenu" aria-haspopup="true" aria-expanded="false" href="#">
          <i class="nav-main-link-icon fa fa-coffee"></i>
          <span class="nav-main-link-name">Get Started</span>
        </a>
        <ul class="nav-main-submenu">
          <li class="nav-main-item">
            <a class="nav-main-link" href="gs_backend.html">
              <span class="nav-main-link-name">Backend</span>
            </a>
          </li>
          <li class="nav-main-item">
            <a class="nav-main-link" href="gs_backend_boxed.html">
              <span class="nav-main-link-name">Backend Boxed</span>
            </a>
          </li>
          <li class="nav-main-item">
            <a class="nav-main-link" href="gs_landing.html">
              <span class="nav-main-link-name">Landing</span>
            </a>
          </li>
          <li class="nav-main-item">
            <a class="nav-main-link" href="gs_rtl_backend.html">
              <span class="nav-main-link-name">RTL Backend</span>
            </a>
          </li>
          <li class="nav-main-item">
            <a class="nav-main-link" href="gs_rtl_backend_boxed.html">
              <span class="nav-main-link-name">RTL Backend Boxed</span>
            </a>
          </li>
          <li class="nav-main-item">
            <a class="nav-main-link" href="gs_rtl_landing.html">
              <span class="nav-main-link-name">RTL Landing</span>
            </a>
          </li>
        </ul>
      </li> --}}


