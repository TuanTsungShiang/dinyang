<?php

namespace App\Filament\Resources;

use App\Filament\Resources\ProductResource\Pages;
use App\Filament\Resources\ProductResource\RelationManagers;
use App\Models\Product;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class ProductResource extends Resource
{
    protected static ?string $model = Product::class;
    protected static ?string $navigationIcon = 'heroicon-o-cube';
    protected static ?string $navigationGroup = '產品管理';
    protected static ?string $navigationLabel = '產品';
    protected static ?int $navigationSort = 2;

    public static function form(Form $form): Form
    {
        return $form->schema([
            Forms\Components\Section::make('基本資訊')->schema([
                Forms\Components\Select::make('category_id')
                    ->relationship('category', 'name')
                    ->required()
                    ->label('分類'),
                Forms\Components\TextInput::make('code')
                    ->label('型號'),
                Forms\Components\TextInput::make('name')
                    ->required()
                    ->label('名稱')
                    ->columnSpanFull(),
                Forms\Components\TextInput::make('slug')
                    ->required()
                    ->label('Slug')
                    ->columnSpanFull(),
                Forms\Components\TextInput::make('short_description')
                    ->required()
                    ->label('簡短說明')
                    ->columnSpanFull(),
                Forms\Components\Textarea::make('long_description')
                    ->label('完整說明')
                    ->rows(4)
                    ->columnSpanFull(),
            ])->columns(2),

            Forms\Components\Section::make('產品特色')->schema([
                Forms\Components\Repeater::make('features')
                    ->schema([
                        Forms\Components\TextInput::make('icon')->label('圖示')->placeholder('🔧'),
                        Forms\Components\TextInput::make('title')->required()->label('標題'),
                        Forms\Components\Textarea::make('description')->required()->label('說明')->rows(2),
                    ])
                    ->columns(3)
                    ->columnSpanFull()
                    ->label(''),
            ]),

            Forms\Components\Section::make('規格表')->schema([
                Forms\Components\Repeater::make('specifications')
                    ->schema([
                        Forms\Components\TextInput::make('label')->required()->label('項目'),
                        Forms\Components\TextInput::make('value')->required()->label('值'),
                    ])
                    ->columns(2)
                    ->columnSpanFull()
                    ->label(''),
            ]),

            Forms\Components\Section::make('媒體')->schema([
                Forms\Components\TextInput::make('icon')->label('產品圖示（emoji / 路徑）'),
                Forms\Components\FileUpload::make('thumbnail')
                    ->image()
                    ->directory('products/thumbnails')
                    ->label('縮圖'),
                Forms\Components\FileUpload::make('gallery')
                    ->image()
                    ->multiple()
                    ->directory('products/gallery')
                    ->label('圖庫')
                    ->columnSpanFull(),
            ])->columns(2),

            Forms\Components\Section::make('訂購資訊 & 發布')->schema([
                Forms\Components\TextInput::make('min_order_qty')->label('最低訂量'),
                Forms\Components\TextInput::make('lead_time_days')->label('交期'),
                Forms\Components\TextInput::make('sort_order')
                    ->required()
                    ->numeric()
                    ->default(0)
                    ->label('排序'),
                Forms\Components\Toggle::make('is_published')
                    ->required()
                    ->label('發布'),
                Forms\Components\DateTimePicker::make('published_at')->label('發布時間'),
                Forms\Components\TextInput::make('meta_title')->label('SEO 標題'),
                Forms\Components\TextInput::make('meta_description')->label('SEO 描述'),
            ])->columns(2),
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\ImageColumn::make('thumbnail')->label('圖'),
                Tables\Columns\TextColumn::make('category.name')
                    ->label('分類')
                    ->sortable(),
                Tables\Columns\TextColumn::make('name')
                    ->label('名稱')
                    ->searchable(),
                Tables\Columns\TextColumn::make('code')
                    ->label('型號')
                    ->searchable(),
                Tables\Columns\TextColumn::make('short_description')
                    ->label('簡介')
                    ->limit(40)
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\IconColumn::make('is_published')
                    ->label('已發布')
                    ->boolean(),
                Tables\Columns\TextColumn::make('sort_order')
                    ->label('排序')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->defaultSort('sort_order')
            ->filters([
                Tables\Filters\SelectFilter::make('category_id')
                    ->relationship('category', 'name')
                    ->label('分類'),
                Tables\Filters\TrashedFilter::make(),
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
                Tables\Actions\RestoreAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                    Tables\Actions\RestoreBulkAction::make(),
                ]),
            ]);
    }

    public static function getRelations(): array
    {
        return [
            RelationManagers\ApplicationAreasRelationManager::class,
            RelationManagers\RelatedProductsRelationManager::class,
        ];
    }

    public static function getPages(): array
    {
        return [
            'index'  => Pages\ListProducts::route('/'),
            'create' => Pages\CreateProduct::route('/create'),
            'edit'   => Pages\EditProduct::route('/{record}/edit'),
        ];
    }

    public static function getEloquentQuery(): \Illuminate\Database\Eloquent\Builder
    {
        return parent::getEloquentQuery()
            ->withoutGlobalScopes([SoftDeletingScope::class]);
    }
}
