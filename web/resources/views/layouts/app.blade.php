<!doctype html>
<html lang="zh-Hant">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>@yield('title', '定陽企業有限公司｜專業線材加工與連接器整合服務')</title>
    <meta
      name="description"
      content="@yield('description', '定陽企業有限公司提供線材加工、連接器組裝、客製線組、OEM/ODM 與技術支援，服務自動化、半導體、醫療設備與機器人製造產業。')"
    />
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    @stack('styles')
  </head>

  <body>
    <main class="page">
      @include('partials.header')

      <div class="page-body">
        @yield('content')
      </div>

      @include('partials.footer')
    </main>
    @stack('scripts')
  </body>
</html>
