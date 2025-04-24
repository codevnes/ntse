<?php
/**
 * Tạo 5 sản phẩm ngẫu nhiên về xử lý nước
 */

// Đảm bảo chỉ admin mới có thể chạy script này
function nts_create_sample_water_products() {
    if (!current_user_can('manage_options')) {
        return;
    }

    // Dữ liệu mẫu cho sản phẩm
    $product_types = [
        'Máy lọc nước',
        'Lõi lọc nước',
        'Bể lọc nước',
        'Thiết bị xử lý nước thải',
        'Hệ thống lọc nước công nghiệp',
        'Bộ lọc đầu nguồn',
        'Máy lọc nước RO',
        'Máy lọc nước điện giải'
    ];

    $product_names = [
        'Máy lọc nước RO Aqua Plus %d tầng',
        'Lõi lọc số %d - Lọc than hoạt tính',
        'Bể lọc nước composite %d lớp',
        'Hệ thống xử lý nước thải sinh hoạt %dM³/ngày',
        'Bộ lọc đầu nguồn đa năng %d cấp độ',
        'Máy lọc nước điện giải ion kiềm %d tấm điện cực',
        'Hệ thống lọc nước công nghiệp %d m³/h',
        'Màng RO công nghiệp %d GPD'
    ];

    $price_ranges = [
        '1,500,000 VNĐ - 3,000,000 VNĐ',
        '350,000 VNĐ - 700,000 VNĐ',
        '5,000,000 VNĐ - 10,000,000 VNĐ',
        'Liên hệ để được tư vấn',
        '7,500,000 VNĐ - 12,000,000 VNĐ',
        '15,000,000 VNĐ - 25,000,000 VNĐ',
        '50,000,000 VNĐ - 150,000,000 VNĐ',
        '4,500,000 VNĐ'
    ];

    $short_descriptions = [
        'Công nghệ lọc RO tiên tiến, loại bỏ đến 99.9% tạp chất, vi khuẩn và kim loại nặng.',
        'Lõi lọc cao cấp với khả năng hấp thụ mùi, màu và hóa chất độc hại trong nước.',
        'Bể lọc composite bền bỉ, không gỉ sét, có khả năng chịu áp lực cao.',
        'Hệ thống xử lý nước thải tự động với công nghệ vi sinh tiên tiến.',
        'Thiết bị lọc đầu nguồn hiệu quả, bảo vệ đường ống và thiết bị sử dụng nước.',
        'Công nghệ điện giải ion tiên tiến, tạo nước kiềm có lợi cho sức khỏe.',
        'Hệ thống lọc công suất lớn, đáp ứng nhu cầu sử dụng cho nhà máy, khách sạn.',
        'Sản phẩm nhập khẩu 100%, đạt tiêu chuẩn NSF International.',
        'Thiết kế hiện đại, tiết kiệm không gian, dễ dàng lắp đặt và bảo dưỡng.'
    ];

    $product_overviews = [
        'Máy lọc nước RO của chúng tôi sử dụng công nghệ thẩm thấu ngược (Reverse Osmosis) hiện đại nhất, với khả năng loại bỏ đến 99.9% các tạp chất, vi khuẩn, virus, kim loại nặng và các chất ô nhiễm khác trong nước. Hệ thống đa tầng lọc đảm bảo nước đầu ra tinh khiết, an toàn cho sức khỏe của cả gia đình bạn. 

Thiết bị được thiết kế nhỏ gọn, tiết kiệm không gian, phù hợp với mọi không gian nhà bếp. Vỏ máy làm từ nhựa ABS cao cấp, bền bỉ và dễ dàng vệ sinh. Bảng điều khiển thông minh với đèn báo thay lõi giúp người dùng dễ dàng theo dõi và bảo dưỡng máy.',

        'Bộ lọc đầu nguồn của chúng tôi là giải pháp toàn diện để xử lý nước ngay từ đầu vào, bảo vệ toàn bộ hệ thống đường ống và các thiết bị sử dụng nước trong gia đình hoặc cơ sở kinh doanh. Sản phẩm có khả năng loại bỏ cặn bẩn, sắt, mangan, clo và các tạp chất khác trong nước.

Bộ lọc sử dụng cơ chế lọc cơ học kết hợp với hấp thụ hóa học, đảm bảo hiệu quả lọc cao và tuổi thọ dài. Hệ thống van xả tự động giúp việc bảo dưỡng trở nên đơn giản và thuận tiện.',

        'Hệ thống xử lý nước thải sinh hoạt của chúng tôi là giải pháp hiệu quả và thân thiện với môi trường. Sử dụng công nghệ xử lý vi sinh hiếu khí kết hợp với kỹ thuật lọc tiên tiến, hệ thống có khả năng xử lý các chất ô nhiễm trong nước thải sinh hoạt đạt tiêu chuẩn xả thải Loại A theo QCVN 14:2008/BTNMT.

Thiết bị hoạt động tự động, có bộ điều khiển thông minh với khả năng tự điều chỉnh các thông số vận hành dựa trên lưu lượng và nồng độ ô nhiễm đầu vào. Hệ thống tiết kiệm năng lượng, chi phí vận hành thấp và không sử dụng nhiều hóa chất trong quá trình xử lý.'
    ];

    $product_purposes = [
        'Cung cấp nước uống tinh khiết, an toàn cho sức khỏe, loại bỏ tạp chất và kim loại nặng độc hại trong nước.',
        'Bảo vệ đường ống và các thiết bị sử dụng nước khỏi cặn bẩn, tăng tuổi thọ của thiết bị và giảm chi phí bảo dưỡng.',
        'Xử lý nước thải sinh hoạt đạt tiêu chuẩn xả thải, bảo vệ môi trường và tuân thủ quy định pháp luật.',
        'Cung cấp giải pháp lọc nước hiệu quả cho các cơ sở sản xuất, kinh doanh với nhu cầu sử dụng nước lớn.',
        'Tạo nước kiềm có lợi cho sức khỏe, hỗ trợ điều hòa độ pH trong cơ thể và tăng cường hệ miễn dịch.'
    ];

    $target_customers = [
        'Các hộ gia đình quan tâm đến chất lượng nước sử dụng, đặc biệt là các gia đình có trẻ nhỏ, người già hoặc người có hệ miễn dịch yếu.',
        'Chung cư, khu dân cư với nhu cầu xử lý nước đầu nguồn để bảo vệ hệ thống đường ống và thiết bị sử dụng nước.',
        'Nhà hàng, khách sạn, trường học và các cơ sở kinh doanh dịch vụ thực phẩm cần nguồn nước sạch, đạt tiêu chuẩn.',
        'Các nhà máy, xí nghiệp sản xuất với nhu cầu xử lý nước thải công nghiệp hoặc cung cấp nước sạch cho quy trình sản xuất.',
        'Bệnh viện, phòng khám và các cơ sở y tế cần nguồn nước tinh khiết cho các thiết bị y tế và điều trị.',
        'Các khu đô thị, khu nghỉ dưỡng cần hệ thống xử lý nước thải tập trung với công suất lớn.'
    ];

    $key_benefits = [
        'Loại bỏ 99.9% vi khuẩn, virus, kim loại nặng và tạp chất trong nước
Tiết kiệm chi phí mua nước đóng chai
Cung cấp nước tinh khiết tại vòi, tiện lợi sử dụng
Thiết kế nhỏ gọn, tiết kiệm không gian
Dễ dàng lắp đặt và bảo dưỡng
Tăng cường sức khỏe nhờ nguồn nước sạch',

        'Tăng tuổi thọ cho thiết bị sử dụng nước và hệ thống đường ống
Tiết kiệm chi phí sửa chữa và thay thế thiết bị
Loại bỏ cặn bẩn, sắt, mangan và các tạp chất trong nước
Cải thiện chất lượng nước sinh hoạt cho cả gia đình
Bảo vệ da và tóc khỏi tác động của clo và kim loại nặng
Không sử dụng điện, tiết kiệm năng lượng',

        'Đạt tiêu chuẩn xả thải Loại A theo QCVN 14:2008/BTNMT
Vận hành tự động, giảm thiểu nhân công giám sát
Chi phí bảo dưỡng thấp
Không gây mùi, không ô nhiễm môi trường
Tiết kiệm không gian với thiết kế module
Sử dụng vật liệu bền bỉ, tuổi thọ cao'
    ];

    $product_materials = [
        '<h3>Công nghệ lọc đa tầng</h3>
<p>Máy lọc nước của chúng tôi sử dụng công nghệ lọc đa tầng, bao gồm:</p>
<ul>
<li><strong>Lõi PP (Polypropylene)</strong>: Làm từ sợi polypropylene cuộn cùng chiều, có khả năng lọc cặn thô, bùn đất, rỉ sét với hiệu suất cao.</li>
<li><strong>Lõi than hoạt tính dạng hạt (GAC)</strong>: Sản xuất từ than dừa tự nhiên, qua quá trình hoạt hóa đặc biệt, tạo ra than với bề mặt xốp lên đến 1000m²/g, có khả năng hấp thụ mạnh các chất hữu cơ, clo và cải thiện vị của nước.</li>
<li><strong>Lõi than hoạt tính dạng khối (CTO)</strong>: Sản xuất bằng cách nén than hoạt tính và polyme đặc biệt, tạo thành khối than đặc, giúp tăng thời gian tiếp xúc với nước, nâng cao hiệu quả lọc.</li>
<li><strong>Màng RO (Reverse Osmosis)</strong>: Nhập khẩu từ Mỹ, với cấu trúc xoắn ốc đặc biệt, lỗ màng chỉ 0.0001 micron, có khả năng loại bỏ đến 99.9% tạp chất, vi khuẩn, virus, kim loại nặng.</li>
</ul>',

        '<h3>Vật liệu composite bền bỉ</h3>
<p>Bể lọc nước của chúng tôi được sản xuất từ vật liệu composite cao cấp với các đặc tính nổi bật:</p>
<ul>
<li><strong>Lớp lót PE</strong>: Đảm bảo an toàn thực phẩm, không phản ứng với nước và hóa chất xử lý nước.</li>
<li><strong>Lớp sợi thủy tinh</strong>: Gia cường độ bền, khả năng chịu áp lực cao lên đến 6 bar.</li>
<li><strong>Lớp phủ bảo vệ UV</strong>: Giúp bể không bị lão hóa khi đặt ngoài trời, kéo dài tuổi thọ.</li>
</ul>
<p>Bể composite có tuổi thọ trên 20 năm, không gỉ sét, nhẹ hơn 70% so với bể thép, dễ dàng lắp đặt và vận chuyển.</p>',

        '<h3>Công nghệ màng MBR tiên tiến</h3>
<p>Hệ thống xử lý nước thải của chúng tôi sử dụng công nghệ màng sinh học MBR (Membrane Bioreactor), kết hợp quá trình xử lý sinh học truyền thống với công nghệ lọc màng:</p>
<ul>
<li><strong>Màng lọc PVDF</strong>: Vật liệu Polyvinylidene Fluoride cao cấp, kích thước lỗ màng 0.01-0.1 micron, có khả năng loại bỏ hoàn toàn chất rắn lơ lửng và vi sinh vật.</li>
<li><strong>Giá thể sinh học MBBR</strong>: Làm từ nhựa HDPE, với diện tích bề mặt riêng lên đến 500m²/m³, tạo môi trường lý tưởng cho vi sinh vật phát triển, tăng hiệu quả xử lý.</li>
</ul>'
    ];

    $production_technology = [
        '<h3>Quy trình sản xuất máy lọc nước RO</h3>
<p>Máy lọc nước của chúng tôi được sản xuất theo quy trình nghiêm ngặt với các công đoạn chính:</p>
<ol>
<li><strong>Thiết kế và mô phỏng</strong>: Sử dụng phần mềm CAD/CAM tiên tiến để thiết kế và tối ưu hóa luồng chảy của nước.</li>
<li><strong>Sản xuất linh kiện</strong>: Các linh kiện nhựa được sản xuất bằng máy ép phun với khuôn mẫu chính xác, đảm bảo độ bền và kín khít.</li>
<li><strong>Lắp ráp trên dây chuyền tự động</strong>: Giảm thiểu sai sót do con người, đảm bảo chất lượng đồng đều.</li>
<li><strong>Kiểm tra áp suất</strong>: Mỗi máy đều được kiểm tra áp suất ở mức 8 bar để đảm bảo không rò rỉ.</li>
<li><strong>Kiểm tra chất lượng nước đầu ra</strong>: Đo TDS, độ pH và kiểm tra vi sinh trước khi đóng gói.</li>
</ol>',

        '<h3>Công nghệ xử lý nước thải vi sinh hiếu khí</h3>
<p>Hệ thống xử lý nước thải của chúng tôi áp dụng công nghệ vi sinh hiếu khí tiên tiến:</p>
<ol>
<li><strong>Thiết kế bể ngăn A2O</strong>: Kết hợp 3 quá trình Yếm khí (Anaerobic) - Thiếu khí (Anoxic) - Hiếu khí (Oxic) để loại bỏ hiệu quả BOD, COD, nitơ và phốt pho.</li>
<li><strong>Hệ thống sục khí tiết kiệm năng lượng</strong>: Sử dụng đĩa sục khí mịn EPDM nhập khẩu, với lỗ sục 1-3mm, hiệu quả truyền khí cao, tiết kiệm 30% điện năng.</li>
<li><strong>Công nghệ lọc màng thẩm thấu</strong>: Áp dụng công nghệ lọc màng UF hoặc MF để tách bùn hoạt tính ra khỏi nước sau xử lý sinh học.</li>
</ol>',

        '<h3>Công nghệ điện giải ion kiềm tiên tiến</h3>
<p>Máy lọc nước điện giải của chúng tôi sử dụng công nghệ điện cực titanium phủ platinum:</p>
<ol>
<li><strong>Điện cực Titanium phủ Platinum</strong>: Chất lượng cao, tuổi thọ lên đến 10 năm, không giải phóng kim loại nặng trong quá trình điện phân.</li>
<li><strong>Màng ngăn Nafion</strong>: Sản xuất bởi DuPont (Mỹ), cho phép tách hiệu quả khoang anode và cathode trong quá trình điện phân.</li>
<li><strong>Hệ thống điều khiển thông minh</strong>: Tự động điều chỉnh cường độ dòng điện dựa trên TDS của nước đầu vào để tạo ra nước với độ pH ổn định.</li>
</ol>'
    ];

    $product_applications = [
        '<h3>Ứng dụng của máy lọc nước RO</h3>
<p>Máy lọc nước RO được ứng dụng rộng rãi trong nhiều lĩnh vực:</p>
<ul>
<li><strong>Sử dụng trong gia đình</strong>: Cung cấp nước uống tinh khiết, an toàn cho cả gia đình, đặc biệt là trẻ em và người già.</li>
<li><strong>Nhà hàng, khách sạn</strong>: Đảm bảo nguồn nước sạch cho chế biến thực phẩm và phục vụ khách hàng.</li>
<li><strong>Văn phòng, trường học</strong>: Cung cấp nước uống tiện lợi cho nhân viên và học sinh.</li>
<li><strong>Ngành y tế</strong>: Sản xuất nước tinh khiết cho các thiết bị y tế và điều trị.</li>
</ul>',

        '<h3>Ứng dụng của bộ lọc đầu nguồn</h3>
<p>Bộ lọc đầu nguồn có nhiều ứng dụng thiết thực:</p>
<ul>
<li><strong>Khu dân cư, chung cư</strong>: Bảo vệ hệ thống đường ống và thiết bị sử dụng nước cho toàn bộ tòa nhà.</li>
<li><strong>Nhà máy, xí nghiệp</strong>: Xử lý nước đầu vào cho các quy trình sản xuất yêu cầu nước sạch.</li>
<li><strong>Hệ thống nông nghiệp</strong>: Lọc nước tưới tiêu, ngăn chặn tắc nghẽn hệ thống tưới nhỏ giọt và phun sương.</li>
<li><strong>Bể bơi, spa</strong>: Lọc cặn bẩn, cải thiện chất lượng nước và giảm nhu cầu sử dụng hóa chất xử lý.</li>
</ul>',

        '<h3>Ứng dụng của hệ thống xử lý nước thải</h3>
<p>Hệ thống xử lý nước thải được ứng dụng trong nhiều môi trường:</p>
<ul>
<li><strong>Khu đô thị, khu dân cư</strong>: Xử lý nước thải sinh hoạt tập trung, đảm bảo môi trường sống xanh sạch.</li>
<li><strong>Khách sạn, resort</strong>: Xử lý nước thải để tái sử dụng cho mục đích tưới cây, rửa đường.</li>
<li><strong>Nhà máy chế biến thực phẩm</strong>: Xử lý nước thải có hàm lượng chất hữu cơ cao từ quá trình sản xuất.</li>
<li><strong>Bệnh viện, cơ sở y tế</strong>: Xử lý nước thải y tế đặc thù, loại bỏ mầm bệnh và dược chất.</li>
</ul>'
    ];

    $product_certificates = [
        'Chứng nhận ISO 9001:2015 về Hệ thống quản lý chất lượng
Chứng nhận ISO 14001:2015 về Hệ thống quản lý môi trường
Chứng nhận NSF/ANSI 58 cho hệ thống lọc nước RO
Giấy chứng nhận hợp quy QCVN 02:2009/BKHCN
Giấy xác nhận đủ điều kiện sản xuất, kinh doanh thiết bị lọc nước',

        'Chứng nhận ISO 9001:2015 về Hệ thống quản lý chất lượng
Chứng nhận ISO 14001:2015 về Hệ thống quản lý môi trường
Giấy chứng nhận hợp quy QCVN 02:2009/BKHCN
Giấy phép xả thải theo QCVN 14:2008/BTNMT
Chứng nhận an toàn vệ sinh thực phẩm cho thiết bị xử lý nước',

        'Chứng nhận ISO 9001:2015 về Hệ thống quản lý chất lượng
Giấy phép xả thải theo QCVN 14:2008/BTNMT
Giấy chứng nhận an toàn điện theo tiêu chuẩn IEC
Chứng nhận CE (Châu Âu) cho thiết bị điện tử
Giấy phép kinh doanh thiết bị xử lý nước'
    ];

    // Mẫu cho đánh giá khách hàng
    $reviews = [
        [
            'content' => 'Gia đình tôi đã sử dụng máy lọc nước này được hơn 1 năm và rất hài lòng. Nước uống tinh khiết, không còn mùi clo. Đặc biệt là trẻ nhỏ trong nhà rất thích uống nước từ máy lọc này.',
            'name' => 'Anh Nguyễn Văn Nam',
            'position' => 'Kỹ sư IT, Hà Nội',
            'rating' => 5
        ],
        [
            'content' => 'Bộ lọc đầu nguồn đã giải quyết triệt để vấn đề nước nhiễm sắt tại nhà tôi. Nước sinh hoạt không còn màu vàng, thiết bị vệ sinh không còn bị ố vàng. Rất đáng tiền!',
            'name' => 'Chị Trần Thị Hoa',
            'position' => 'Giáo viên, TP. Hồ Chí Minh',
            'rating' => 4
        ],
        [
            'content' => 'Hệ thống xử lý nước thải mà công ty tư vấn và lắp đặt cho khu nghỉ dưỡng của chúng tôi hoạt động rất hiệu quả. Nước sau xử lý đạt chuẩn và có thể tái sử dụng cho việc tưới cây, tiết kiệm đáng kể chi phí.',
            'name' => 'Ông Lê Minh Tuấn',
            'position' => 'Giám đốc Khu nghỉ dưỡng Xanh, Phú Quốc',
            'rating' => 5
        ],
        [
            'content' => 'Máy lọc nước điện giải đã cải thiện đáng kể sức khỏe của gia đình tôi. Vợ tôi hết đau dạ dày, còn tôi thì huyết áp ổn định hơn sau 3 tháng sử dụng.',
            'name' => 'Bác sĩ Phạm Văn Khoa',
            'position' => 'Bệnh viện Đa khoa Trung ương',
            'rating' => 5
        ],
        [
            'content' => 'Nhà máy sản xuất thực phẩm của chúng tôi đã sử dụng hệ thống lọc nước công nghiệp và rất hài lòng về chất lượng nước đầu ra. Hệ thống hoạt động ổn định, ít hỏng hóc.',
            'name' => 'Anh Hoàng Minh Đức',
            'position' => 'Trưởng phòng Kỹ thuật, Công ty Thực phẩm ABC',
            'rating' => 4
        ]
    ];

    // Mẫu cho FAQ
    $faqs = [
        [
            'question' => 'Thời gian bảo hành sản phẩm là bao lâu?',
            'answer' => 'Sản phẩm được bảo hành chính hãng 24 tháng cho toàn bộ máy và 12 tháng cho các linh kiện điện tử. Chúng tôi cam kết hỗ trợ kỹ thuật trọn đời sản phẩm.',
            'link' => ''
        ],
        [
            'question' => 'Sau bao lâu cần thay lõi lọc?',
            'answer' => 'Lõi PP và CTO nên thay sau 6 tháng sử dụng. Lõi than hoạt tính GAC nên thay sau 12 tháng. Màng RO có tuổi thọ từ 24-36 tháng tùy theo chất lượng nước đầu vào và tần suất sử dụng.',
            'link' => ''
        ],
        [
            'question' => 'Chi phí lắp đặt và bảo dưỡng như thế nào?',
            'answer' => 'Chúng tôi miễn phí lắp đặt trong phạm vi 20km từ trung tâm thành phố. Chi phí bảo dưỡng định kỳ 6 tháng/lần với giá 300,000 VNĐ/lần, bao gồm vệ sinh hệ thống và kiểm tra chất lượng nước.',
            'link' => ''
        ],
        [
            'question' => 'Sản phẩm có thể lọc được những loại nước nào?',
            'answer' => 'Sản phẩm có thể lọc nước máy, nước giếng khoan, nước giếng đào và các nguồn nước ngầm khác. Tuy nhiên, đối với nước có độ đục cao, nước nhiễm mặn hoặc nước nhiễm kim loại nặng đậm đặc, cần có hệ thống tiền xử lý đặc biệt.',
            'link' => ''
        ],
        [
            'question' => 'Có dịch vụ tư vấn và khảo sát miễn phí không?',
            'answer' => 'Có, chúng tôi cung cấp dịch vụ tư vấn và khảo sát miễn phí để đề xuất giải pháp phù hợp nhất với nhu cầu và điều kiện thực tế của khách hàng. Vui lòng liên hệ hotline 0123.456.789 để đặt lịch.',
            'link' => ''
        ],
        [
            'question' => 'Thời gian lắp đặt hệ thống là bao lâu?',
            'answer' => 'Thời gian lắp đặt tùy thuộc vào loại sản phẩm. Máy lọc nước gia đình: 2-3 giờ. Bộ lọc đầu nguồn: 4-5 giờ. Hệ thống xử lý nước thải: 2-5 ngày tùy công suất và điều kiện lắp đặt.',
            'link' => ''
        ],
        [
            'question' => 'Sản phẩm đã được chứng nhận chất lượng chưa?',
            'answer' => 'Tất cả sản phẩm của chúng tôi đều đạt các chứng nhận chất lượng quốc gia và quốc tế như ISO 9001:2015, ISO 14001:2015, chứng nhận hợp quy QCVN 02:2009/BKHCN và nhiều chứng nhận khác tùy từng loại sản phẩm.',
            'link' => ''
        ]
    ];

    // Tạo 5 sản phẩm ngẫu nhiên
    for ($i = 1; $i <= 5; $i++) {
        // Tạo dữ liệu ngẫu nhiên
        $product_type_index = array_rand($product_types);
        $product_name_index = array_rand($product_names);
        $price_index = array_rand($price_ranges);
        $short_desc_index = array_rand($short_descriptions);
        $overview_index = array_rand($product_overviews);
        $purpose_index = array_rand($product_purposes);
        $customers_index = array_rand($target_customers);
        $benefits_index = array_rand($key_benefits);
        $materials_index = array_rand($product_materials);
        $tech_index = array_rand($production_technology);
        $applications_index = array_rand($product_applications);
        $certificates_index = array_rand($product_certificates);

        // Tạo tiêu đề sản phẩm
        $random_number = mt_rand(3, 9);
        $product_title = sprintf($product_names[$product_name_index], $random_number);

        // Tạo mã sản phẩm
        $product_code = 'WF-' . strtoupper(substr(md5(uniqid()), 0, 6));

        // Tạo post mới
        $post_data = array(
            'post_title'    => $product_title,
            'post_content'  => $product_overviews[$overview_index],
            'post_status'   => 'publish',
            'post_type'     => 'product',
            'post_excerpt'  => $short_descriptions[$short_desc_index],
        );

        // Chèn post
        $post_id = wp_insert_post($post_data);

        if (!is_wp_error($post_id)) {
            // Thêm metabox data
            update_post_meta($post_id, '_product_code', $product_code);
            update_post_meta($post_id, '_product_price', $price_ranges[$price_index]);
            update_post_meta($post_id, '_product_specs', 'Thông số kỹ thuật chi tiết của ' . $product_title);
            update_post_meta($post_id, '_product_features', 'Các tính năng nổi bật của ' . $product_title);
            
            // Hero Banner
            update_post_meta($post_id, '_product_type', $product_types[$product_type_index]);
            update_post_meta($post_id, '_short_description', $short_descriptions[$short_desc_index]);
            
            // Tổ            // Tổng quan sản phẩm
            update_post_meta($post_id, '_product_overview', $product_overviews[$overview_index]);
            update_post_meta($post_id, '_product_purpose', $product_purposes[$purpose_index]);
            update_post_meta($post_id, '_target_customers', $target_customers[$customers_index]);
            update_post_meta($post_id, '_key_benefits', $key_benefits[$benefits_index]);
            
            // Công nghệ vật chất
            update_post_meta($post_id, '_product_materials', $product_materials[$materials_index]);
            update_post_meta($post_id, '_production_technology', $production_technology[$tech_index]);
            
            // Ứng dụng nổi bật
            update_post_meta($post_id, '_product_applications', $product_applications[$applications_index]);
            update_post_meta($post_id, '_product_certificates', $product_certificates[$certificates_index]);
            
            // Đánh giá khách hàng - lấy ngẫu nhiên 2-3 đánh giá
            $num_reviews = mt_rand(2, 3);
            $selected_reviews = array_rand($reviews, $num_reviews);
            $product_reviews = array();
            
            if (!is_array($selected_reviews)) {
                $selected_reviews = array($selected_reviews);
            }
            
            foreach ($selected_reviews as $review_index) {
                $product_reviews[] = $reviews[$review_index];
            }
            update_post_meta($post_id, '_product_reviews', $product_reviews);
            
            // FAQ - lấy ngẫu nhiên 4-6 câu hỏi
            $num_faqs = mt_rand(4, 6);
            $selected_faqs = array_rand($faqs, $num_faqs);
            $product_faqs = array();
            
            if (!is_array($selected_faqs)) {
                $selected_faqs = array($selected_faqs);
            }
            
            foreach ($selected_faqs as $faq_index) {
                $product_faqs[] = $faqs[$faq_index];
            }
            update_post_meta($post_id, '_product_faqs', $product_faqs);
            
            // Gán danh mục ngẫu nhiên
            $categories = array('Máy lọc nước', 'Thiết bị xử lý nước', 'Hệ thống lọc nước công nghiệp', 'Thiết bị lọc đầu nguồn', 'Phụ kiện lọc nước');
            $selected_cat = $categories[array_rand($categories)];
            $term = term_exists($selected_cat, 'product_category');
            
            // Nếu danh mục chưa tồn tại, tạo mới
            if (!$term) {
                $term = wp_insert_term($selected_cat, 'product_category');
            }
            
            if (!is_wp_error($term)) {
                wp_set_object_terms($post_id, $term['term_id'], 'product_category');
            }
            
            // Gán thương hiệu ngẫu nhiên
            $brands = array('Aqua Clean', 'Pure Tech', 'WaterPro', 'EcoFilter', 'HydroLife');
            $selected_brand = $brands[array_rand($brands)];
            $brand_term = term_exists($selected_brand, 'product_brand');
            
            // Nếu thương hiệu chưa tồn tại, tạo mới
            if (!$brand_term) {
                $brand_term = wp_insert_term($selected_brand, 'product_brand');
            }
            
            if (!is_wp_error($brand_term)) {
                wp_set_object_terms($post_id, $brand_term['term_id'], 'product_brand', true);
            }
            
            // Tạo thumbnail ngẫu nhiên - sử dụng placeholder.com hoặc có thể sử dụng hình ảnh có sẵn
            $attachment_id = 0;
            
            // Đây chỉ là phương pháp mẫu, trong thực tế bạn cần upload hình ảnh thật
            // Hoặc cung cấp ID của attachment đã tồn tại trong thư viện media
            // $attachment_id = YOUR_ATTACHMENT_ID;
            
            if ($attachment_id) {
                set_post_thumbnail($post_id, $attachment_id);
            }
            
            echo "Đã tạo sản phẩm: " . $product_title . " (ID: " . $post_id . ")<br>";
        } else {
            echo "Lỗi khi tạo sản phẩm: " . $product_title . "<br>";
        }
    }
    
    echo "Hoàn tất việc tạo 5 sản phẩm ngẫu nhiên về xử lý nước!";
}

// Thêm menu trang quản trị để chạy script
function nts_add_product_generator_menu() {
    add_management_page(
        'Tạo sản phẩm mẫu',
        'Tạo sản phẩm mẫu',
        'manage_options',
        'nts-generate-products',
        'nts_product_generator_page'
    );
}
add_action('admin_menu', 'nts_add_product_generator_menu');

// Trang quản trị
function nts_product_generator_page() {
    ?>
    <div class="wrap">
        <h1>Tạo sản phẩm mẫu về xử lý nước</h1>
        
        <?php
        // Kiểm tra xem có đang submit form không
        if (isset($_POST['generate_products']) && check_admin_referer('nts_generate_products_nonce')) {
            nts_create_sample_water_products();
        } else {
        ?>
            <p>Công cụ này sẽ tạo 5 sản phẩm mẫu ngẫu nhiên về xử lý nước với đầy đủ thông tin metabox theo cấu trúc đã đăng ký.</p>
            <p><strong>Lưu ý:</strong> Sản phẩm được tạo ra sẽ không có hình ảnh thực tế. Bạn cần thêm hình ảnh sau khi tạo.</p>
            
            <form method="post">
                <?php wp_nonce_field('nts_generate_products_nonce'); ?>
                <p class="submit">
                    <input type="submit" name="generate_products" class="button button-primary" value="Tạo 5 sản phẩm mẫu">
                </p>
            </form>
        <?php
        }
        ?>
    </div>
    <?php
}