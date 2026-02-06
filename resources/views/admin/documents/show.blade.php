@extends('admin.layout')

@section('content')
<div class="container-fluid">
    <div class="mb-4">
        <a href="{{ route('admin.documents.index') }}" class="btn btn-outline-secondary">
            <i class="fas fa-arrow-left"></i> Back to List
        </a>
    </div>

    <div class="row">
        <div class="col-md-5">
            <div class="card shadow-sm mb-4">
                <div class="card-header bg-primary text-white">
                    <h5 class="mb-0">Applicant Details</h5>
                </div>
                <div class="card-body">
                    <table class="table table-borderless">
                        <tr>
                            <th width="150">Full Name:</th>
                            <td>{{ $document->application?->Full_Name ?? 'N/A' }}</td>
                        </tr>
                        <tr>
                            <th>Gender:</th>
                            <td>{{ $document->application?->Gender ?? 'N/A' }}</td>
                        </tr>
                        <tr>
                            <th>Date of Birth:</th>
                            <td>{{ $document->application && $document->application->Date_of_Birth ? date('Y-m-d', strtotime($document->application->Date_of_Birth)) : 'N/A' }}</td>
                        </tr>
                        <tr>
                            <th>Phone:</th>
                            <td>{{ $document->application?->Phone_Number ?? 'N/A' }}</td>
                        </tr>
                        <tr>
                            <th>Address:</th>
                            <td>
                                {{ $document->application?->Address ?? 'N/A' }}<br>
                                {{ $document->application?->Street ?? '' }}, {{ $document->application?->City ?? '' }}<br>
                                {{ $document->application?->Province ?? '' }}
                            </td>
                        </tr>
                        <tr>
                            <th>Status:</th>
                            <td>
                                <span class="badge bg-{{ $document->verification_status === 'approved' ? 'success' : ($document->verification_status === 'rejected' ? 'danger' : 'warning') }}">
                                    {{ ucfirst($document->verification_status) }}
                                </span>
                            </td>
                        </tr>
                    </table>
                </div>
            </div>

            @if($document->verification_status === 'pending')
            <div class="card shadow-sm">
                <div class="card-header bg-dark text-white">
                    <h5 class="mb-0">Update Verification Status</h5>
                </div>
                <div class="card-body">
                    <form action="{{ route('admin.documents.update-status', $document->Document_ID) }}" method="POST">
                        @csrf
                        <div class="mb-3">
                            <label class="form-label">Status</label>
                            <select name="status" class="form-control" required>
                                <option value="approved">Approve</option>
                                <option value="rejected">Reject</option>
                            </select>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Remarks (Optional)</label>
                            <textarea name="remarks" class="form-control" rows="3"></textarea>
                        </div>
                        <button type="submit" class="btn btn-primary w-100">Update Status</button>
                    </form>
                </div>
            </div>
            @endif
        </div>

        <div class="col-md-7">
            <div class="card shadow-sm mb-4">
                <div class="card-header bg-info text-white d-flex justify-content-between align-items-center">
                    <h5 class="mb-0">Documents Preview</h5>
                </div>
                <div class="card-body">
                    <ul class="nav nav-tabs mb-3" id="docTabs" role="tablist">
                        <li class="nav-item">
                            <a class="nav-link active" id="nic-tab" data-bs-toggle="tab" href="#nic" role="tab">NIC Card</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" id="birth-tab" data-bs-toggle="tab" href="#birth" role="tab">Birth Certificate</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" id="photo-tab" data-bs-toggle="tab" href="#photo" role="tab">Passport Photo</a>
                        </li>
                    </ul>
                    <div class="tab-content" id="docTabsContent">
                        <div class="tab-pane fade show active" id="nic" role="tabpanel">
                            @if($document->NIC_card)
                                <div class="ratio ratio-4x3 mb-3">
                                    <iframe src="{{ route('admin.documents.file', ['path' => $document->NIC_card]) }}" class="border rounded"></iframe>
                                </div>
                                <a href="{{ route('admin.documents.file', ['path' => $document->NIC_card]) }}" target="_blank" class="btn btn-sm btn-outline-primary">Open in new tab</a>
                            @else
                                <p class="text-muted">No NIC card uploaded.</p>
                            @endif
                        </div>
                        <div class="tab-pane fade" id="birth" role="tabpanel">
                            @if($document->Birth_Certificate)
                                <div class="ratio ratio-4x3 mb-3">
                                    <iframe src="{{ route('admin.documents.file', ['path' => $document->Birth_Certificate]) }}" class="border rounded"></iframe>
                                </div>
                                <a href="{{ route('admin.documents.file', ['path' => $document->Birth_Certificate]) }}" target="_blank" class="btn btn-sm btn-outline-primary">Open in new tab</a>
                            @else
                                <p class="text-muted">No birth certificate uploaded.</p>
                            @endif
                        </div>
                        <div class="tab-pane fade" id="photo" role="tabpanel">
                            @if($document->Photo)
                                <div class="text-center">
                                    <img src="{{ route('admin.documents.file', ['path' => $document->Photo]) }}" class="img-fluid border rounded mb-3" style="max-height: 400px;">
                                    <br>
                                    <a href="{{ route('admin.documents.file', ['path' => $document->Photo]) }}" target="_blank" class="btn btn-sm btn-outline-primary">Open in new tab</a>
                                </div>
                            @else
                                <p class="text-muted">No photo uploaded.</p>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
