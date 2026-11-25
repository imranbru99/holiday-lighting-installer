<?php

namespace App\Filament\Resources;

use App\Filament\Resources\ProjectResource\Pages;
use App\Models\Project;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;

class ProjectResource extends Resource
{
    protected static ?string $model = Project::class;
    protected static ?string $navigationIcon = 'heroicon-o-wrench-screwdriver';
    protected static ?string $navigationGroup = 'Operations';
    protected static ?string $navigationLabel = 'Jobs / Projects';
    protected static ?int $navigationSort = 1;

    public static function form(Form $form): Form
    {
        return $form->schema([
            Forms\Components\TextInput::make('job_number')->required()->unique(ignoreRecord: true)->default(fn () => 'JOB-'.now()->format('ymd').'-'.random_int(100, 999)),
            Forms\Components\Select::make('customer_id')->relationship('customer', 'name')->searchable()->required()->preload(),
            Forms\Components\TextInput::make('title')->required()->maxLength(180)->columnSpanFull(),
            Forms\Components\Select::make('service_type')->options([
                'roofline-c9' => 'Roofline C9',
                'permanent-led' => 'Permanent LED Track',
                'commercial-displays' => 'Commercial Displays',
                'wreaths-garland' => 'Wreaths & Garland',
                'tree-wraps' => 'Tree & Landscape Wraps',
                'takedown-storage' => 'Takedown & Storage',
            ])->required(),
            Forms\Components\Select::make('status')->options([
                'quoted' => 'Quoted',
                'scheduled' => 'Scheduled',
                'in_progress' => 'In Progress',
                'completed' => 'Completed',
                'invoiced' => 'Invoiced',
                'cancelled' => 'Cancelled',
            ])->required()->default('quoted'),
            Forms\Components\TextInput::make('sq_ft')
                ->label('Linear feet')
                ->numeric()
                ->suffix('linear ft')
                ->helperText('Stored in sq_ft column — enter roofline or display length in linear feet'),
            Forms\Components\TextInput::make('quoted_amount')->numeric()->prefix('$'),
            Forms\Components\TextInput::make('final_amount')->numeric()->prefix('$'),
            Forms\Components\DatePicker::make('start_date'),
            Forms\Components\DatePicker::make('end_date'),
            Forms\Components\Textarea::make('site_address')->rows(2)->columnSpanFull(),
            Forms\Components\Textarea::make('notes')->rows(3)->columnSpanFull(),
        ])->columns(2);
    }

    public static function table(Table $table): Table
    {
        return $table->columns([
            Tables\Columns\TextColumn::make('job_number')->searchable()->sortable(),
            Tables\Columns\TextColumn::make('title')->searchable()->limit(30),
            Tables\Columns\TextColumn::make('customer.name')->searchable(),
            Tables\Columns\BadgeColumn::make('status')->colors([
                'warning' => 'quoted',
                'info' => 'scheduled',
                'primary' => 'in_progress',
                'success' => 'completed',
                'gray' => 'invoiced',
                'danger' => 'cancelled',
            ]),
            Tables\Columns\TextColumn::make('service_type')->label('Service')->formatStateUsing(fn (?string $state) => match ($state) {
                'roofline-c9' => 'Roofline C9',
                'permanent-led' => 'Permanent LED',
                'commercial-displays' => 'Commercial',
                'wreaths-garland' => 'Wreaths',
                'tree-wraps' => 'Tree wraps',
                'takedown-storage' => 'Takedown',
                default => $state,
            }),
            Tables\Columns\TextColumn::make('sq_ft')->label('Linear ft')->suffix(' ft'),
            Tables\Columns\TextColumn::make('quoted_amount')->money('USD'),
            Tables\Columns\TextColumn::make('start_date')->date(),
        ])->filters([
            Tables\Filters\SelectFilter::make('status')->options([
                'quoted' => 'Quoted', 'scheduled' => 'Scheduled', 'in_progress' => 'In Progress',
                'completed' => 'Completed', 'invoiced' => 'Invoiced', 'cancelled' => 'Cancelled',
            ]),
            Tables\Filters\SelectFilter::make('service_type')->options([
                'roofline-c9' => 'Roofline C9',
                'permanent-led' => 'Permanent LED',
                'commercial-displays' => 'Commercial',
                'wreaths-garland' => 'Wreaths',
                'tree-wraps' => 'Tree wraps',
                'takedown-storage' => 'Takedown',
            ]),
        ])->actions([
            Tables\Actions\EditAction::make(),
        ])->bulkActions([
            Tables\Actions\BulkActionGroup::make([Tables\Actions\DeleteBulkAction::make()]),
        ]);
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListProjects::route('/'),
            'create' => Pages\CreateProject::route('/create'),
            'edit' => Pages\EditProject::route('/{record}/edit'),
        ];
    }
}