<?php

namespace App\Filament\Resources;

use App\Filament\Resources\HeroSlideResource\Pages;
use App\Filament\Resources\HeroSlideResource\RelationManagers;
use App\Models\HeroSlide;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class HeroSlideResource extends Resource
{
    protected static ?string $model = HeroSlide::class;

    protected static ?string $navigationIcon = 'heroicon-o-photo';
    protected static ?string $navigationGroup = '外觀設定';
    protected static ?string $navigationLabel = 'Hero 輪播';
    protected static ?int $navigationSort = 1;

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('title')
                    ->required(),
                Forms\Components\TextInput::make('subtitle'),
                Forms\Components\TextInput::make('eyebrow'),
                Forms\Components\FileUpload::make('image_path')
                    ->image()
                    ->required(),
                Forms\Components\FileUpload::make('image_focal_point')
                    ->image(),
                Forms\Components\Textarea::make('overlay_gradient')
                    ->columnSpanFull(),
                Forms\Components\TextInput::make('cta_primary_label'),
                Forms\Components\TextInput::make('cta_primary_url'),
                Forms\Components\TextInput::make('cta_secondary_label'),
                Forms\Components\TextInput::make('cta_secondary_url'),
                Forms\Components\TextInput::make('cta_secondary_icon'),
                Forms\Components\Toggle::make('is_active')
                    ->required(),
                Forms\Components\TextInput::make('sort_order')
                    ->required()
                    ->numeric()
                    ->default(0),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('title')
                    ->searchable(),
                Tables\Columns\TextColumn::make('subtitle')
                    ->searchable(),
                Tables\Columns\TextColumn::make('eyebrow')
                    ->searchable(),
                Tables\Columns\ImageColumn::make('image_path'),
                Tables\Columns\ImageColumn::make('image_focal_point'),
                Tables\Columns\TextColumn::make('cta_primary_label')
                    ->searchable(),
                Tables\Columns\TextColumn::make('cta_primary_url')
                    ->searchable(),
                Tables\Columns\TextColumn::make('cta_secondary_label')
                    ->searchable(),
                Tables\Columns\TextColumn::make('cta_secondary_url')
                    ->searchable(),
                Tables\Columns\TextColumn::make('cta_secondary_icon')
                    ->searchable(),
                Tables\Columns\IconColumn::make('is_active')
                    ->boolean(),
                Tables\Columns\TextColumn::make('sort_order')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('updated_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListHeroSlides::route('/'),
            'create' => Pages\CreateHeroSlide::route('/create'),
            'edit' => Pages\EditHeroSlide::route('/{record}/edit'),
        ];
    }
}
