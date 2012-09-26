USE [EWS]
GO

/****** Object:  Table [dbo].[eBayReturnPolicy]    Script Date: 09/26/2012 23:16:34 ******/
SET ANSI_NULLS ON
GO

SET QUOTED_IDENTIFIER ON
GO

CREATE TABLE [dbo].[eBayReturnPolicy](
	[Id] [uniqueidentifier] NOT NULL,
	[Description] [ntext] NULL,
	[EAN] [nvarchar](255) NULL,
	[RefundOption] [nvarchar](255) NULL,
	[ReturnsAcceptedOption] [nvarchar](255) NULL,
	[ReturnsWithinOption] [nvarchar](255) NULL,
	[ShippingCostPaidByOption] [nvarchar](255) NULL,
	[WarrantyDurationOption] [nvarchar](255) NULL,
	[WarrantyOfferedOption] [nvarchar](255) NULL,
	[WarrantyTypeOption] [nvarchar](255) NULL,
	[Refund] [nvarchar](255) NULL,
	[ReturnsAccepted] [nvarchar](255) NULL,
	[ReturnsWithin] [nvarchar](255) NULL,
	[ShippingCostPaidBy] [nvarchar](255) NULL,
	[WarrantyDuration] [nvarchar](255) NULL,
	[WarrantyOffered] [nvarchar](255) NULL,
	[WarrantyType] [nvarchar](255) NULL,
 CONSTRAINT [PK_eBayReturnPolicy] PRIMARY KEY CLUSTERED 
(
	[Id] ASC
)WITH (PAD_INDEX  = OFF, STATISTICS_NORECOMPUTE  = OFF, IGNORE_DUP_KEY = OFF, ALLOW_ROW_LOCKS  = ON, ALLOW_PAGE_LOCKS  = ON) ON [PRIMARY]
) ON [PRIMARY] TEXTIMAGE_ON [PRIMARY]

GO

ALTER TABLE [dbo].[eBayReturnPolicy] ADD  CONSTRAINT [DF_eBayReturnPolicy_Id]  DEFAULT (newsequentialid()) FOR [Id]
GO

