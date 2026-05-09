<?php

namespace App\Filament\Resources;

use App\Filament\Resources\HeroSlideResource\Pages;
use App\Models\HeroSlide;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;

class HeroSlideResource extends Resource
{
    protected static ?string $model = HeroSlide::class;
    protected static ?string $navigationIcon  = 'heroicon-o-photo';
    protected static ?string $navigationGroup = '外觀設定';
    protected static ?string $navigationLabel = 'Hero 輪播';
    protected static ?int    $navigationSort  = 1;

    public static function form(Form $form): Form
    {
        return $form->schema([

            Forms\Components\Section::make('主要內容')->schema([
                Forms\Components\TextInput::make('title')
                    ->required()->label('主標題')->columnSpanFull(),
                Forms\Components\TextInput::make('subtitle')
                    ->label('副標題')->columnSpanFull(),
                Forms\Components\TextInput::make('eyebrow')
                    ->label('眉標（小標籤）'),
                Forms\Components\Toggle::make('is_active')
                    ->label('啟用')->default(true)->required(),
                Forms\Components\TextInput::make('sort_order')
                    ->label('排序')->numeric()->default(0)->required(),
            ])->columns(2),

            Forms\Components\Section::make('背景圖片')->schema([
                Forms\Components\FileUpload::make('image_path')
                    ->label('主背景圖')
                    ->acceptedFileTypes(['image/jpeg', 'image/png', 'image/gif', 'image/webp'])
                    ->directory('hero')
                    ->required()
                    ->columnSpanFull(),
                Forms\Components\FileUpload::make('image_focal_point')
                    ->label('焦點圖（選填）')
                    ->acceptedFileTypes(['image/jpeg', 'image/png', 'image/gif', 'image/webp'])
                    ->directory('hero')
                    ->columnSpanFull(),
            ]),

            Forms\Components\Section::make('按鈕 CTA')->schema([
                Forms\Components\TextInput::make('cta_primary_label')
                    ->label('主按鈕文字')->placeholder('立即詢價 →'),
                Forms\Components\TextInput::make('cta_primary_url')
                    ->label('主按鈕連結')->placeholder('/#contact'),
                Forms\Components\TextInput::make('cta_secondary_label')
                    ->label('次按鈕文字')->placeholder('加入 LINE'),
                Forms\Components\TextInput::make('cta_secondary_url')
                    ->label('次按鈕連結')->placeholder('https://line.me/...'),
                Forms\Components\TextInput::make('cta_secondary_icon')
                    ->label('次按鈕 Icon 路徑')->placeholder('/img/icon/line_bubble.png'),
            ])->columns(2),

            Forms\Components\Section::make('進階設定')->schema([
                Forms\Components\Textarea::make('overlay_gradient')
                    ->label('覆蓋漸層 CSS（選填）')
                    ->rows(2)
                    ->columnSpanFull(),
            ])->collapsible()->collapsed(),

        ])->columns(1); // 讓 section 撐滿整個寬度
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\ImageColumn::make('image_path')->label('背景圖'),
                Tables\Columns\TextColumn::make('title')->label('主標題')->searchable()->limit(30),
                Tables\Columns\TextColumn::make('eyebrow')->label('眉標')->searchable()->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\IconColumn::make('is_active')->label('啟用')->boolean(),
                Tables\Columns\TextColumn::make('sort_order')->label('排序')->sortable(),
            ])
            ->defaultSort('sort_order')
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }

    public static function getRelations(): array
    {
        return [];
    }

    public static function getPages(): array
    {
        return [
            'index'  => Pages\ListHeroSlides::route('/'),
            'create' => Pages\CreateHeroSlide::route('/create'),
            'edit'   => Pages\EditHeroSlide::route('/{record}/edit'),
        ];
    }
}
