<?php

namespace App\Filament\Resources;

use App\Filament\Resources\JobResource\Pages;
use App\Models\Job;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;

class JobResource extends Resource
{
    protected static ?string $model = Job::class;
    protected static ?string $navigationIcon  = 'heroicon-o-briefcase';
    protected static ?string $navigationGroup = '人才招募';
    protected static ?string $navigationLabel = '職缺管理';
    protected static ?int    $navigationSort  = 1;

    public static function form(Form $form): Form
    {
        return $form->schema([
            Forms\Components\Section::make('職缺基本資訊')->schema([
                Forms\Components\TextInput::make('title')
                    ->required()->label('職位名稱'),
                Forms\Components\TextInput::make('department')
                    ->label('部門'),
                Forms\Components\TextInput::make('location')
                    ->default('桃園市龜山區')->label('工作地點'),
                Forms\Components\Select::make('type')
                    ->options([
                        'full-time' => '正職',
                        'part-time' => '兼職',
                        'contract'  => '合約',
                    ])
                    ->default('full-time')
                    ->required()->label('工作類型'),
                Forms\Components\Toggle::make('is_active')
                    ->default(true)->required()->label('開放應徵'),
                Forms\Components\TextInput::make('sort_order')
                    ->numeric()->default(0)->label('排序'),
            ])->columns(2),

            Forms\Components\Section::make('職缺說明')->schema([
                Forms\Components\Textarea::make('description')
                    ->rows(6)->label('工作內容')->columnSpanFull(),
                Forms\Components\Textarea::make('requirements')
                    ->rows(6)->label('應徵條件')->columnSpanFull(),
            ]),
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('title')->label('職位')->searchable(),
                Tables\Columns\TextColumn::make('department')->label('部門')->searchable(),
                Tables\Columns\TextColumn::make('location')->label('地點'),
                Tables\Columns\TextColumn::make('type')
                    ->label('類型')
                    ->badge()
                    ->formatStateUsing(fn ($state) => match($state) {
                        'full-time' => '正職',
                        'part-time' => '兼職',
                        'contract'  => '合約',
                        default     => $state,
                    })
                    ->color(fn ($state) => match($state) {
                        'full-time' => 'success',
                        'part-time' => 'info',
                        'contract'  => 'warning',
                        default     => 'gray',
                    }),
                Tables\Columns\IconColumn::make('is_active')->label('開放中')->boolean(),
                Tables\Columns\TextColumn::make('sort_order')->label('排序')->sortable(),
            ])
            ->defaultSort('sort_order')
            ->actions([Tables\Actions\EditAction::make()])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }

    public static function getPages(): array
    {
        return [
            'index'  => Pages\ListJobs::route('/'),
            'create' => Pages\CreateJob::route('/create'),
            'edit'   => Pages\EditJob::route('/{record}/edit'),
        ];
    }
}
