<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Validation Language Lines
    |--------------------------------------------------------------------------
    |
    | The following language lines contain the default error messages used by
    | the validator class. Some of these rules have multiple versions such
    | such as the size rules. Feel free to tweak each of these messages.
    |
    */

    'accepted'             => ':attribute kabul edilmelidir.',
    'active_url'           => ':attribute geçerli bir URL olmalıdır.',
    'after'                => ':attribute şundan daha eski bir tarih olmalıdır :date.',
    'after_or_equal'       => 'The :attribute must be a date after or equal to :date.',
    'alpha'                => ':attribute sadece harflerden oluşmalıdır.',
    'alpha_dash'           => ':attribute sadece harfler, rakamlar ve tirelerden oluşmalıdır.',
    'alpha_num'            => ':attribute sadece harfler ve rakamlar içermelidir.',
    'array'                => ':attribute dizi olmalıdır.',
    'before'               => ':attribute şundan daha önceki bir tarih olmalıdır :date.',
    'before_or_equal'      => 'The :attribute must be a date before or equal to :date.',
    'between'              => [
        'numeric' => ':attribute :min - :max arasında olmalıdır.',
        'file'    => ':attribute :min - :max arasındaki kilobayt değeri olmalıdır.',
        'string'  => ':attribute :min - :max arasında karakterden oluşmalıdır.',
        'array'   => ':attribute :min - :max arasında nesneye sahip olmalıdır.',
    ],
    'boolean'              => ':attribute sadece doğru veya yanlış olmalıdır.',
    'confirmed'            => ':attribute tekrarı eşleşmiyor.',
    'date'                 => ':attribute geçerli bir tarih olmalıdır.',
    'date_format'          => ':attribute :format biçimi ile eşleşmiyor.',
    'different'            => ':attribute ile :other birbirinden farklı olmalıdır.',
    'digits'               => ':attribute :digits rakam olmalıdır.',
    'digits_between'       => ':attribute :min ile :max arasında rakam olmalıdır.',
    'dimensions'           => ':attribute görsel ölçüleri geçersiz.',
    'distinct'             => ':attribute alanı yinelenen bir değere sahip.',
    'email'                => ':attribute biçimi geçersiz.',
    'exists'               => 'Seçili :attribute geçersiz.',
    'file'                 => ':attribute dosya olmalıdır.',
    'filled'               => ':attribute alanı gereklidir.',
    'image'                => ':attribute alanı resim dosyası olmalıdır.',
    'in'                   => ':attribute değeri geçersiz.',
    'in_array'             => ':attribute alanı :other içinde mevcut değil.',
    'integer'              => ':attribute tamsayı olmalıdır.',
    'ip'                   => ':attribute geçerli bir IP adresi olmalıdır.',
    'ipv4'                 => 'The :attribute must be a valid IPv4 address.',
    'ipv6'                 => 'The :attribute must be a valid IPv6 address.',
    'json'                 => ':attribute geçerli bir JSON değişkeni olmalıdır.',
    'max'                  => [
        'numeric' => ':attribute değeri :max değerinden küçük olmalıdır.',
        'file'    => ':attribute değeri :max kilobayt değerinden küçük olmalıdır.',
        'string'  => ':attribute değeri :max karakter değerinden küçük olmalıdır.',
        'array'   => ':attribute değeri :max adedinden az nesneye sahip olmalıdır.',
    ],
    'mimes'                => ':attribute dosya biçimi :values olmalıdır.',
    'mimetypes'            => ':attribute dosya biçimi :values olmalıdır.',
    'min'                  => [
        'numeric' => ':attribute değeri :min değerinden büyük olmalıdır.',
        'file'    => ':attribute değeri :min kilobayt değerinden büyük olmalıdır.',
        'string'  => ':attribute değeri :min karakter değerinden büyük olmalıdır.',
        'array'   => ':attribute en az :min nesneye sahip olmalıdır.',
    ],
    'not_in'               => 'Seçili :attribute geçersiz.',
    'numeric'              => ':attribute sayı olmalıdır.',
    'present'              => 'The :attribute field must be present.',
    'regex'                => ':attribute biçimi geçersiz.',
    'required'             => ':attribute alanı gereklidir.',
    'required_if'          => ':attribute alanı, :other :value değerine sahip olduğunda zorunludur.',
    'required_unless'      => 'The :attribute field is required unless :other is in :values.',
    'required_with'        => ':attribute alanı :values varken zorunludur.',
    'required_with_all'    => ':attribute alanı herhangi bir :values değeri varken zorunludur.',
    'required_without'     => ':attribute alanı :values yokken zorunludur.',
    'required_without_all' => ':attribute alanı :values değerlerinden herhangi biri yokken zorunludur.',
    'same'                 => ':attribute ile :other eşleşmelidir.',
    'size'                 => [
        'numeric' => ':attribute :size olmalıdır.',
        'file'    => ':attribute :size kilobyte olmalıdır.',
        'string'  => ':attribute :size karakter olmalıdır.',
        'array'   => ':attribute :size nesneye sahip olmalıdır.',
    ],
    'string'               => ':attribute dizge olmalıdır.',
    'timezone'             => ':attribute geçerli bir saat dilimi olmalıdır.',
    'unique'               => ':attribute daha önceden kayıt edilmiş.',
    'uploaded'             => 'The :attribute failed to upload.',
    'url'                  => ':attribute biçimi geçersiz.',
    'iban'                 => ":attribute, geçerli bir Uluslararası Banka Hesap Numarası (IBAN) olmalıdır.",
    'bic'                  => ':attribute geçerli bir İşletme Tanımlayıcı Kodu (BIC) değil.',
    'unique_with'          => ':fields alan kombinasyonları daha önceden kaydedilmiş.',

    /*
    |--------------------------------------------------------------------------
    | Custom Validation Language Lines
    |--------------------------------------------------------------------------
    |
    | Here you may specify custom validation messages for attributes using the
    | convention "attribute.rule" to name the lines. This makes it quick to
    | specify a specific custom language line for a given attribute rule.
    |
    */


    'custom' => [
        'captcha' => [
            'required' => 'Captcha Gerekli!',
            'captcha'  => "Yanlış Captcha.",
        ],
        'amount' => [
            'required'  => "Lütfen Bir Miktar Yazin.",
            'min'  => "Lütfen geçerli bir miktar yazin.",
            'max'  => "Lütfen geçerli bir miktar yazin.",
            'between' => "Lütfen 10 ile 10000 arasında bir Miktar girin."
        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | Custom Validation Attributes
    |--------------------------------------------------------------------------
    |
    | The following language lines are used to swap attribute place-holders
    | with something more reader friendly such as E-Mail Address instead
    | of "email". This simply helps us make messages a little cleaner.
    |
    */

    'attributes'           => [
        'name'                  => 'Ad',
        'username'              => 'Kullanıcı adı',
        'email'                 => 'Email',
        'firstname'             => 'İsim',
        'lastname'              => 'Soyadı',
        'password'              => 'Şifre',
        'password_confirmation' => 'Şifre Onaylama',
        'city'                  => 'Şehir',
        'country'               => 'Ülke',
        'address'               => 'Adres',
        'phone'                 => 'Telefon',
        'mobile'                => 'Cep telefonu',
        'age'                   => 'Yaş',
        'sex'                   => 'Seks',
        'gender'                => 'Cinsiyet',
        'day'                   => 'Gün',
        'month'                 => 'Ay',
        'year'                  => 'Yıl',
        'hour'                  => 'Saat',
        'minute'                => 'Dakika',
        'second'                => 'İkinci',
        'title'                 => 'Başlık',
        'text'                  => 'Metin',
        'content'               => 'İçerik',
        'description'           => 'Açıklama',
        'excerpt'               => 'Alıntı',
        'date'                  => 'Tarih',
        'time'                  => 'Zaman',
        'available'             => 'Kullanılabilir',
        'size'                  => 'Boyut',
        'terms'                 => 'Şartlar',
        'bank_name'             => 'Banka Adı',
        'branch_name'           => 'Şube Adı',
        'swift_code'            => 'Swift kodu',
        'iban_code'             => 'iBan kodu',
        'tel'                   => 'Cep Telefon Numarası',
        'fax'                   => 'Faks Numarası',
        'amount'                => 'Tutar',
        'contactText'           => 'Iletişim metni',
        'account_number'        => 'Hesap Numarası',
        'user_id‌'               => 'Kullanıcı ID',
    ],

];
