<?php
// Add a temporary admin page to generate partners
add_action('admin_menu', 'add_generate_partners_page');

function add_generate_partners_page() {
    add_submenu_page(
        'nts-content-settings',
        'Generate Random Partners',
        'Generate Partners',
        'manage_options',
        'generate-partners',
        'generate_partners_callback'
    );
}

function generate_partners_callback() {
    if (!current_user_can('manage_options')) {
        wp_die(__('You do not have sufficient permissions to access this page.'));
    }

    // Check if the form was submitted
    if (isset($_POST['generate_partners'])) {
        // Company name prefixes and suffixes for random generation
        $prefixes = [
            'Aqua', 'Hydro', 'Pure', 'Flow', 'Clear', 'Blue', 'Fresh', 'Eco', 'Green', 'Tech',
            'Smart', 'Pro', 'Global', 'National', 'International', 'Advanced', 'Modern', 'Elite',
            'Premier', 'Superior', 'Ultra', 'Mega', 'Alpha', 'Delta', 'Omega'
        ];

        $suffixes = [
            'Water', 'Aqua', 'Solutions', 'Systems', 'Technologies', 'Engineering', 'Industries',
            'Group', 'Corp', 'Inc', 'Ltd', 'Co', 'Enterprises', 'Services', 'Innovations',
            'Dynamics', 'Works', 'Tech', 'Labs', 'Research'
        ];

        // Partner types
        $types = ['product', 'software', 'project'];

        // Descriptions for each type
        $descriptions = [
            'product' => [
                'Chuyên cung cấp thiết bị lọc nước công nghiệp và dân dụng với chất lượng cao.',
                'Nhà cung cấp hàng đầu về hóa chất xử lý nước và thiết bị quan trắc.',
                'Cung cấp vật tư, thiết bị và phụ kiện cho hệ thống xử lý nước thải.',
                'Chuyên sản xuất và phân phối màng lọc RO, UF và các vật liệu lọc tiên tiến.',
                'Cung cấp bơm, van và các thiết bị điều khiển cho hệ thống xử lý nước.',
                'Nhà sản xuất thiết bị lọc nước uống trực tiếp với công nghệ tiên tiến.',
                'Cung cấp các giải pháp lọc nước biển thành nước ngọt cho các khu vực ven biển.',
                'Chuyên cung cấp vật liệu lọc đa tầng và hệ thống lọc nước giếng khoan.'
            ],
            'software' => [
                'Cung cấp phần mềm quản lý và giám sát hệ thống xử lý nước thời gian thực.',
                'Chuyên về giải pháp phần mềm tự động hóa cho nhà máy xử lý nước.',
                'Phát triển phần mềm mô phỏng và thiết kế hệ thống xử lý nước.',
                'Cung cấp giải pháp IoT cho việc giám sát chất lượng nước từ xa.',
                'Phát triển ứng dụng di động cho việc quản lý và bảo trì hệ thống xử lý nước.',
                'Chuyên về phần mềm phân tích dữ liệu và dự báo chất lượng nước.',
                'Cung cấp giải pháp phần mềm quản lý khách hàng cho doanh nghiệp ngành nước.'
            ],
            'project' => [
                'Đối tác chiến lược trong các dự án xử lý nước thải công nghiệp quy mô lớn.',
                'Hợp tác triển khai các dự án cấp nước sạch cho khu vực nông thôn.',
                'Đối tác trong các dự án xử lý nước nhiễm mặn tại các tỉnh ven biển.',
                'Hợp tác triển khai hệ thống xử lý nước thải y tế cho các bệnh viện.',
                'Đối tác trong các dự án xử lý nước thải cho khu công nghiệp.',
                'Hợp tác triển khai các dự án cấp nước sạch cho khu đô thị mới.',
                'Đối tác chiến lược trong các dự án tái sử dụng nước thải.',
                'Hợp tác triển khai các dự án xử lý nước ngầm nhiễm asen và amoni.'
            ]
        ];

        // Generate random website URLs
        function generateWebsite($companyName) {
            $companyName = strtolower(str_replace(' ', '', $companyName));
            $domains = ['.com', '.vn', '.com.vn', '.net', '.org', '.co'];
            $domain = $domains[array_rand($domains)];
            return 'https://www.' . $companyName . $domain;
        }

        // Generate random partners
        $partners = [];
        $count = rand(20, 25); // Random number between 20 and 25

        for ($i = 0; $i < $count; $i++) {
            $prefix = $prefixes[array_rand($prefixes)];
            $suffix = $suffixes[array_rand($suffixes)];
            $name = $prefix . ' ' . $suffix;
            
            $type = $types[array_rand($types)];
            $typeDescriptions = $descriptions[$type];
            $description = $typeDescriptions[array_rand($typeDescriptions)];
            
            $website = generateWebsite($name);
            
            // Use placeholder images for logos
            $logoId = rand(1, 10); // Random number for the placeholder
            $logo = "https://via.placeholder.com/150x100/0099cc/ffffff?text=" . urlencode($prefix);
            
            $partners[] = [
                'name' => $name,
                'logo' => $logo,
                'website' => $website,
                'description' => $description,
                'type' => $type
            ];
        }

        // Save partners to the database
        update_option('nts_partners', $partners);

        echo '<div class="notice notice-success"><p>Successfully generated ' . count($partners) . ' random partners.</p></div>';
    }
    ?>
    <div class="wrap">
        <h1>Generate Random Partners</h1>
        <p>Click the button below to generate 20-25 random partners for testing purposes.</p>
        <form method="post">
            <?php wp_nonce_field('generate_partners_nonce'); ?>
            <input type="submit" name="generate_partners" class="button button-primary" value="Generate Random Partners">
        </form>
        <p style="margin-top: 20px;">
            <a href="<?php echo admin_url('admin.php?page=nts-partners'); ?>" class="button">View Partners</a>
        </p>
    </div>
    <?php
}
