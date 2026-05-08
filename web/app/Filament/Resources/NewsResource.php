<?php

namespace App\Filament\Resources;

use App\Filament\Resources\NewsResource\Pages;
use App\Models\News;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class NewsResource extends Resource
{
    protected static ?string $model = News::class;
    protected static ?string $navigationIcon = 'heroicon-o-newspaper';
    protected static ?string $navigationGroup = '內容管理';
    protected static ?string $navigationLabel = '最新消息';
    protected static ?int $navigationSort = 1;

    public static function form(Form $form): Form
    {
        return $form->schema([
            Forms\Components\Section::make()->schema([
                Forms\Components\Select::make('category_id')
                    ->relationship('category', 'name')
                    ->required()
                    ->label('分類'),
                Forms\Components\TextInput::make('author')
                    ->label('作者'),
                Forms\Components\TextInput::make('title')
                    ->required()
                    ->label('標題')
                    ->columnSpanFull(),
                Forms\Components\TextInput::make('slug')
                    ->required()
                    ->label('Slug')
                    ->columnSpanFull(),
                Forms\Components\Textarea::make('excerpt')
                    ->required()
                    ->label('摘要')
                    ->rows(3)
                    ->columnSpanFull(),
            ])->columns(2),

            Forms\Components\Section::make('內文')->schema([
                Forms\Components\RichEditor::make('content')
                    ->toolbarButtons([
                        'attachFiles', 'blockquote', 'bold', 'bulletList',
                        'codeBlock', 'h2', 'h3', 'italic', 'link',
                        'orderedList', 'redo', 'strike', 'underline', 'undo',
                    ])
                    ->columnSpanFull(),
            ]),

            Forms\Components\Section::make('媒體 & 標籤')->schema([
                Forms\Components\FileUpload::make('cover_image')
                    ->image()
                    ->directory('news/covers')
                    ->label('封面圖'),
                Forms\Components\TagsInput::make('tags')
                    ->label('標籤'),
            ])->columns(2),

            Forms\Components\Section::make('發布設定')->schema([
                Forms\Components\Toggle::make('is_published')
                    ->required()
                    ->label('發布'),
                Forms\Components\DateTimePicker::make('published_at')
                    ->label('發布時間'),
                Forms\Components\TextInput::make('meta_title')
                    ->label('SEO 標題'),
                Forms\Components\TextInput::make('meta_description')
                    ->label('SEO 描述'),
            ])->columns(2),
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('category.name')
                    ->label('分類')
                    ->sortable(),
                Tables\Columns\TextColumn::make('title')
                    ->label('標題')
                    ->searchable()
                    ->limit(40),
                Tables\Columns\TextColumn::make('author')
                    ->label('作者')
                    ->searchable(),
                Tables\Columns\IconColumn::make('is_published')
                    ->label('已發布')
                    ->boolean(),
                Tables\Columns\TextColumn::make('published_at')
                    ->label('發布時間')
                    ->dateTime('Y-m-d')
                    ->sortable(),
                Tables\Columns\TextColumn::make('slug')
                    ->searchable()
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('meta_title')
                    ->searchable()
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->defaultSort('created_at', 'desc')
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
        return [];
    }

    public static function getPages(): array
    {
        return [
            'index'  => Pages\ListNews::route('/'),
            'create' => Pages\CreateNews::route('/create'),
            'edit'   => Pages\EditNews::route('/{record}/edit'),
        ];
    }

    public static function getEloquentQuery(): \Illuminate\Database\Eloquent\Builder
    {
        return parent::getEloquentQuery()
            ->withoutGlobalScopes([SoftDeletingScope::class]);
    }
}
